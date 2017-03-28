<!-- 弹出框 -->
<script src="<?php echo get_css_js_url('sea.js','common');?>"></script>
<script type="text/javascript">
    seajs.config({
        base: "<?php echo $domain['statics']['url'];?>",
        alias: {
          "jquery": "<?php echo get_css_js_url('jquery.min.js', 'common');?>",
          "base": "<?php echo get_css_js_url('base.js','common');?>",
          "dialog": "<?php echo get_css_js_url('dialog.js','common');?>",
          'jqueryswf':"<?php echo get_css_js_url('jquery.swfupload.js', 'common');?>",
          "swfupload" : "<?php echo get_css_js_url('swfupload.js', 'common')?>",
          "admin_uploader": "<?php echo get_css_js_url('m_admin_uploader.js', 'common');?>",
          "bootstrap" : "<?php echo get_css_js_url('bootstrap.min.js', 'common')?>",
        },
        preload: ["jquery"]
    });
</script>
