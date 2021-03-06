<?php 
/**
* 个人设置控制器
* @author jianming@gz-zc.cn
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_admins' => 'Madmins',
            'Model_admins_group' => 'Madmins_group',
            'Model_admins_purview' => 'Madmins_purview',
        ]);
        $this->pageconfig = C('page.page_lists');
        $this->load->library('pagination');

        $this->data['code'] = 'admin_user_manage';
        $this->data['active'] = 'admin_list';
    }
    

    /**
     * 管理员列表
     * 1034487709@qq.com
     */
    public function index() {
        $data = $this->data;
        $data['title'] = array("管理员列表","管理员列表");

        $page =  intval($this->input->get("per_page",true)) ?  : 1;
        $size = $this->pageconfig['per_page'];
        $where['is_del'] = 1;
        if ($this->input->get('name')) {
            $where['name'] = $this->input->get('name');
        }

        if ($this->input->get('fullname')) {
            $where['like']['fullname'] = $this->input->get('fullname');
        }
        $data['name'] = $this->input->get('name');
        $data['fullname'] = $this->input->get('fullname');

        $data['admin_list'] = $this->Madmins->get_lists('*',$where,array("id"=>"asc"),$size,($page-1)*$size);

        $data_count = $this->Madmins->count($where);

        //获取分页
        if(! empty($data['admin_list'])){
            $this->pageconfig['base_url'] = "/admin/index";
            $this->pageconfig['total_rows'] = $data_count;
            $this->pagination->initialize($this->pageconfig);
            $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        }
        $data['page'] = $page;
        $data['data_count'] = $data_count;

        $groups = $this->Madmins_group->get_lists("id,name",array('is_del'=>1));
        $data['groups'] = array_column($groups , 'name','id');

        $admins = $this->Madmins->get_admin_list();
        $data['admins'] = array_column($admins , 'fullname','id');

        $this->load->view("admin/index",$data);
    }

    /**
     * 添加管理员
     * 1034487709@qq.com
     */
    public function add(){

        if(IS_POST)
        {
            $count = $this->Madmins->count(array('is_del'=>1,'name'=>$this->input->post("name",true)));
            if($count){
                   $this->error("管理员已经成功存在");
            }
            
            $da = $this->input->post();
            $da['is_del'] = 1;
            $da['create_admin'] =$this->data['userInfo']['id'] ;
            $da['create_time'] = date("Y-m-d H:i:s");
            $da['password'] = md5(trim($this->input->post("password",true)));

            if(trim($this->input->post("password",true)) != trim($this->input->post("confirpassword",true))){
                $this->error("两次密码不一致");
            }
            unset($da['confirpassword']);
            
            $result_id =  $this->Madmins->create($da);
          
            if($result_id){
                $this->success("添加成功","/admin");
            }else{
               $this->error("添加管理员失败");
            }
        }

        $data = $this->data;
        $data['title'] = array("添加管理员","添加管理员");
       //获取角色
        $data['admin_group'] =  $this->Madmins_group->get_lists("id,name",array("is_del"=>1));

       
        $this->load->view("admin/add",$data);
    }
    

    

    /**
     * 删除管理员
     * 1034487709@qq.com
     */
    public function del($id = 0 )
    {
        #不能删除管理员
        if($id==1)
        {
            $this->return_json(array("code"=>1,"msg"=>"不能删除超级管理员。"));
        }

        #标记删除
        $this->Madmins->update_info(array("is_del"=>2),array("id"=>$id)) ;
        $this->success("操作成功","/admin");
    }

    /**
     * 编辑管理员
     * 1034487709@qq.com
     */
     public function edit($id = 0 )
    {

        if(IS_POST){


            $_POST['id'] = $id;
            //获取原来的group_id
            $old_group_id = $this->Madmins->get_one("group_id,password",array('id'=>$id));
            if($_POST['password']!='' && md5($_POST['password']) != $old_group_id['password'])
            {

                $_POST['password'] = md5($this->input->post("password",'trim'));
            }
            else
            {
                $_POST['password'] = $old_group_id['password'];
            }

            // 修改权限
            if($old_group_id['group_id'] != $_POST['group_id']){
                #获得用户权限
                $purview_ids = $this->Madmins->get_one('purview_ids',array('id'=>$id));#查询某个字段
                $_POST['purview_ids'] = $purview_ids['purview_ids'];

                #获得旧组权限
                $old_group_purview = $this->Madmins_group->get_one('purview_ids',array('id'=>$old_group_id['group_id']));

                #获得新组权限
                $new_group_purview = $this->Madmins_group->get_one('purview_ids',array('id'=>$_POST['group_id']));

                #删除旧组权限
                $_POST['purview_ids'] = $this->Madmins->del_purview($_POST['purview_ids'], $old_group_purview['purview_ids']);

                #添加新组权限
                if($new_group_purview['purview_ids'])
                {
                    $_POST['purview_ids'] .= ','.$new_group_purview['purview_ids'];
                }

            }

            $res = $this->Madmins->replace_into($_POST);
            if($res){
                $this->success("修改成功","/admin");
            }else{
                $this->error("编辑失败,请重新编辑");
            }


        }

        $data = $this->data;
        $data['title'] = array("管理员","编辑管理员");
        //获取角色
        $data['admin_group'] =  $this->Madmins_group->get_lists("id,name",array("is_del"=>1));
        //管理员信息
        $data['info'] = $this->Madmins->get_one("*",array("id"=>$id));


        $this->load->view("admin/edit",$data);
    }

    /**
     * 校验管理员是否存在
     * 1034487709@qq.com
     */
    public function  check_admin(){
        if($this->input->is_ajax_request())
        {
            $name =  $this->input->post("name",true);
            $count = $this->Madmins->count(array('is_del'=>1,'name'=>$name));

            if($count){
                $this->return_json(array("code"=>0));
            }else{
                $this->return_json(array("code"=>1));
            }

        }
    }

    /**
     * 查看管理员
     * 1034487709@qq.com
     */
    public function read($id){
        $data = $this->data;
        $data['info'] = $this->Madmins->get_one("*",array("id"=>$id));
        $data['title'] = array("管理员列表",$data['info']['fullname']);

        $groups = $this->Madmins_group->get_lists("id,name",array('is_del'=>1));
        $data['groups'] = array_column($groups , 'name','id');

        $this->load->view("admin/info",$data);
    }

    /**
     * 管理员权限分配
     * 1034487709@qq.com
     */
    public  function purview($id){

        if(IS_POST)
        {
            $this->Madmins->update_info(array("purview_ids"=>implode(',',$_POST['purview'])),array("id"=>$id));
            $this->success("操作成功","/admin");
        }



        $data = $this->data;
        #用户信息
        $data['info'] = $this->Madmins->get_one("*",array("id"=>$id));
        $data['title'] = array("管理员列表",$data['info']['fullname']);

        #用户组已有权限
        $data['purview_ids'] = explode(',',$data['info']['purview_ids']);

        #获取当前用户所在的组的拥有权限
        $data['group_purview_ids'] = $this->Madmins_group->get_group_info($data['info']['group_id']);

        #所有权限
        $list = $this->Madmins_purview->get_group_purview(explode(",",$data['group_purview_ids']['purview_ids']));

        $data['list'] = class_loop($list);

        $this->load->view("admin/purview",$data);
    }

    /**
     * 个人设置
     * 1034487709@qq.com
     */
    public function set_admin(){
        $data = $this->data;
        $data['info'] = $this->Madmins->get_one("password,fullname,email,tel,describe",array("id"=>$this->data["userInfo"]['id']));
        if(IS_POST){
            $post_data = $_POST;
            if($_POST['password']!='' && md5($_POST['password']) != $data['info']['password'])
            {
                $post_data['password'] = md5($this->input->post("password",'trim'));
            }
            else
            {
                $post_data['password'] = $data['info']['password'];
            }

            $res = $this->Madmins->update_info($post_data,array("id"=>$this->data["userInfo"]['id']));
            if($res){
                $this->success("修改成功","/admin/set_admin");
            }
            else{
                $this->error("操作失败");
            }
        }
        $data['title'] = array("管理员修改信息","个人设置");
        $this->load->view("admin/usercenter/edit",$data);
    }

}
?>
