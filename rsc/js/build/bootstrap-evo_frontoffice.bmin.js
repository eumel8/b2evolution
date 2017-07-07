/* This includes 10 files: src/bootstrap-evo_modal_window.js, src/evo_images.js, src/evo_user_crop.js, src/evo_user_report.js, src/evo_user_contact_groups.js, src/evo_rest_api.js, src/evo_item_flag.js, src/evo_item_resolve.js, src/evo_links.js, ajax.js */
function openModalWindow(a,b,c,d,e,f,g,h,i){var j=void 0===b||"auto"==b?"":"width:"+b+";",k=void 0===c||0==c||""==c?"":"height:"+c,l=k.match(/%$/i)?' style="height:100%;overflow:hidden;"':"",m=c.match(/px/i)?' style="min-height:'+(c.replace("px","")-157)+'px"':"",n=void 0===f||0!=f;if(void 0!==f&&""!=f)if("object"==typeof f)var o=f[0],p=f[1],q=void 0===f[2]?"form":f[2];else var o=f,p="btn-primary",q="form";if(void 0!==g&&g&&jQuery("#modal_window").remove(),0==jQuery("#modal_window").length){var r='<div id="modal_window" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog" style="'+j+k+'"><div class="modal-content"'+l+">";if(void 0!==e&&""!=e&&(r+='<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">'+e+"</h4></div>"),r+='<div class="modal-body"'+l+m+">"+a,i){jQuery("#"+i);r+="<script>jQuery( document ).ready( function() {var iframe = jQuery( '#"+i+"' );iframe.on( 'load', function() {iframe.closest( '.modal-body' ).find( 'span.loader_img' ).remove();setModalIFrameUnload( '"+i+"' );});});<\/script>"}r+="</div>",n&&(r+='<div class="modal-footer">',void 0!==f&&""!=f&&(r+='<button class="btn '+p+'" type="submit" style="display:none">'+o+"</button>"),r+='<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">'+evo_js_lang_close+"</button></div>"),r+="</div></div></div>",jQuery("body").append(r)}else jQuery("#modal_window .modal-body").html(a);void 0!==i?jQuery("#"+i).load(function(){prepareModalWindow(jQuery(this).contents(),q,n,h),jQuery("#modal_window .loader_img").remove(),jQuery("#"+i).show()}):prepareModalWindow("#modal_window",q,n,h);var s={};modal_window_js_initialized&&(s="show"),jQuery("#modal_window").modal(s),""==j&&(jQuery("#modal_window .modal-dialog").css({display:"table",width:"auto"}),jQuery("#modal_window .modal-dialog .modal-content").css({display:"table-cell"})),jQuery("#modal_window").on("hidden",function(){jQuery(this).remove()}),modal_window_js_initialized=!0}function prepareModalWindow(a,b,c,d){c&&(void 0!==d&&d||(jQuery("legend",a).remove(),jQuery("#close_button",a).remove(),jQuery(".panel, .panel-body",a).removeClass("panel panel-default panel-body")),0==jQuery(b+" input[type=submit]",a).length?jQuery("#modal_window .modal-footer button[type=submit]").hide():(jQuery(b+" input[type=submit]",a).hide(),jQuery("#modal_window .modal-footer button[type=submit]").show()),jQuery(b,a).change(function(){var a=jQuery(this).find("input[type=submit]");a.length>0?(a.hide(),jQuery("#modal_window .modal-footer button[type=submit]").show()):jQuery("#modal_window .modal-footer button[type=submit]").hide()}),jQuery("#modal_window .modal-footer button[type=submit]").click(function(){jQuery(b+" input[type=submit]",a).click()})),jQuery(b+" a.btn",a).each(function(){jQuery("#modal_window .modal-footer").prepend("<a href="+jQuery(this).attr("href")+'><button type="button" class="'+jQuery(this).attr("class")+'">'+jQuery(this).html()+"</button></a>"),jQuery(this).remove()}),jQuery(b+" #current_modal_title",a).length>0&&jQuery("#modal_window .modal-title").html(jQuery(b+" #current_modal_title",a).html())}function closeModalWindow(a){return void 0===a&&(a=window.document),jQuery("#modal_window",a).modal("hide"),!1}function setModalIFrameUnload(a){var b=jQuery("#"+a);b[0].contentWindow.onunload=function(){var a=b.closest(".modal-body"),c=jQuery('<span class="loader_img absolute_center" title="'+evo_js_lang_loading+'"></span>');jQuery(a).prepend(c)}}function user_crop_avatar(a,b,c){void 0===c&&(c="avatar");var d=750,e=320,f=jQuery(window).width(),g=jQuery(window).height(),h=f,i=g,j=i/h;i=i>d?d:i<e?e:i,h=h>d?d:h<e?e:h;var k=10,l=10;k=h-2*k>e?10:0,l=i-2*l>e?10:0;var m=h>d?d:h,n=i>d?d:i;openModalWindow('<span id="spinner" class="loader_img loader_user_report absolute_center" title="'+evo_js_lang_loading+'"></span>',m+"px",n+"px",!0,evo_js_lang_crop_profile_pic,[evo_js_lang_crop,"btn-primary"],!0);var o=jQuery("div.modal-dialog div.modal-body").length?jQuery("div.modal-dialog div.modal-body"):jQuery("#overlay_page"),p={top:parseInt(o.css("paddingTop")),right:parseInt(o.css("paddingRight")),bottom:parseInt(o.css("paddingBottom")),left:parseInt(o.css("paddingLeft"))},q=(jQuery("div.modal-dialog div.modal-body").length?parseInt(o.css("min-height")):n-100)-(p.top+p.bottom),r=m-(p.left+p.right),s={user_ID:a,file_ID:b,aspect_ratio:j,content_width:r,content_height:q,display_mode:"js",crumb_user:evo_js_crumb_user};return evo_js_is_backoffice?(s.ctrl="user",s.user_tab="crop",s.user_tab_from=c):(s.blog=evo_js_blog,s.disp="avatar",s.action="crop"),jQuery.ajax({type:"POST",url:evo_js_user_crop_ajax_url,data:s,success:function(a){openModalWindow(a,m+"px",n+"px",!0,evo_js_lang_crop_profile_pic,[evo_js_lang_crop,"btn-primary"])}}),!1}function user_report(a,b){openModalWindow('<span class="loader_img loader_user_report absolute_center" title="'+evo_js_lang_loading+'"></span>',"auto","",!0,evo_js_lang_report_user,[evo_js_lang_report_this_user_now,"btn-danger"],!0);var c={action:"get_user_report_form",user_ID:a,crumb_user:evo_js_crumb_user};return evo_js_is_backoffice?(c.is_backoffice=1,c.user_tab=b):c.blog=evo_js_blog,jQuery.ajax({type:"POST",url:evo_js_user_report_ajax_url,data:c,success:function(a){openModalWindow(a,"auto","",!0,evo_js_lang_report_user,[evo_js_lang_report_this_user_now,"btn-danger"])}}),!1}function user_contact_groups(a){return openModalWindow('<span class="loader_img loader_user_report absolute_center" title="'+evo_js_lang_loading+'"></span>',"auto","",!0,evo_js_lang_contact_groups,evo_js_lang_save,!0),jQuery.ajax({type:"POST",url:evo_js_user_contact_groups_ajax_url,data:{action:"get_user_contact_form",blog:evo_js_blog,user_ID:a,crumb_user:evo_js_crumb_user},success:function(a){openModalWindow(a,"auto","",!0,evo_js_lang_contact_groups,evo_js_lang_save,!0)}}),!1}function evo_rest_api_request(url,params_func,func_method,method){var params=params_func,func=func_method;"function"==typeof params_func&&(func=params_func,params={},method=func_method),void 0===method&&(method="GET"),jQuery.ajax({contentType:"application/json; charset=utf-8",type:method,url:restapi_url+url,data:params}).then(function(data,textStatus,jqXHR){"object"==typeof jqXHR.responseJSON&&eval(func)(data,textStatus,jqXHR)})}function evo_link_fix_wrapper_height(){var a=jQuery("#attachments_fieldset_table").height();jQuery("#attachments_fieldset_wrapper").height()!=a&&jQuery("#attachments_fieldset_wrapper").height(jQuery("#attachments_fieldset_table").height())}function evo_link_change_position(a,b,c){var d=a,e=a.value;return jQuery.get(b+"anon_async.php?action=set_object_link_position&link_ID="+a.id.substr(17)+"&link_position="+e+"&crumb_link="+c,{},function(b,c){b=ajax_debug_clear(b),"OK"==b?(evoFadeSuccess(jQuery(d).closest("tr")),jQuery(d).closest("td").removeClass("error"),"cover"==e&&jQuery("select[name=link_position][id!="+a.id+"] option[value=cover]:selected").each(function(){jQuery(this).parent().val("aftermore"),evoFadeSuccess(jQuery(this).closest("tr"))})):(jQuery(d).val(b),evoFadeFailure(jQuery(d).closest("tr")),jQuery(d.form).closest("td").addClass("error"))}),!1}function evo_link_insert_inline(a,b,c){if("undefined"!=typeof b2evoCanvas){var d="["+a+":"+b;c.length&&(d+=":"+c),d+="]",textarea_wrap_selection(b2evoCanvas,d,"",0,window.document);var e=jQuery("#display_position_"+b);0!=e.length&&"inline"!=e.val()&&(deferInlineReminder=!0,e.val("inline").change(),deferInlineReminder=!1)}}function evo_link_delete(a,b,c,d){return evo_rest_api_request("links/"+c,{action:d},function(d){if("item"==b){var e=window.document.getElementById("itemform_post_content");if(null!=e){var f=new RegExp("\\[(image|file|inline|video|audio|thumbnail):"+c+":?[^\\]]*\\]","ig");textarea_str_replace(e,f,"",window.document)}}jQuery(a).closest("tr").remove(),evo_link_fix_wrapper_height()},"DELETE"),!1}function evo_link_change_order(a,b,c){return evo_rest_api_request("links/"+b+"/"+c,function(b){var d=jQuery(a).closest("tr");"move_up"==c?d.prev().before(d):d.next().after(d),evoFadeSuccess(d)},"POST"),!1}function evo_link_attach(a,b,c,d){return evo_rest_api_request("links",{action:"attach",type:a,object_ID:b,root:c,path:d},function(a){var b=jQuery("#attachments_fieldset_table table",window.parent.document),c=(b.parent,jQuery(a.list_content));b.replaceWith(jQuery("table",c)).promise().done(function(a){setTimeout(function(){window.parent.evo_link_fix_wrapper_height()},10)})}),!1}function evo_link_ajax_loading_overlay(){var a=jQuery("#attachments_fieldset_table"),b=!1;return 0==a.find(".results_ajax_loading").length&&(b=jQuery('<div class="results_ajax_loading"><div>&nbsp;</div></div>'),a.css("position","relative"),b.css({width:a.width(),height:a.height()}),a.append(b)),b}function evo_link_refresh_list(a,b,c){var d=evo_link_ajax_loading_overlay();return d&&evo_rest_api_request("links",{action:void 0===c?"refresh":"sort",type:a,object_ID:b},function(a){jQuery("#attachments_fieldset_table").html(a.html),d.remove(),evo_link_fix_wrapper_height()}),!1}function ajax_debug_clear(a){var b=/<!-- Ajax response end -->/;return a=a.replace(b,""),a=a.replace(/(<div class="jslog">[\s\S]*)/i,""),jQuery.trim(a)}function ajax_response_is_correct(a){var b=/<!-- Ajax response end -->/;return!!a.match(b)&&""!=(a=ajax_debug_clear(a))}var modal_window_js_initialized=!1;jQuery(document).ready(function(){jQuery("img.loadimg").each(function(){jQuery(this).prop("complete")?(jQuery(this).removeClass("loadimg"),""==jQuery(this).attr("class")&&jQuery(this).removeAttr("class")):jQuery(this).on("load",function(){jQuery(this).removeClass("loadimg"),""==jQuery(this).attr("class")&&jQuery(this).removeAttr("class")})})}),jQuery(document).on("click","a.evo_post_flag_btn",function(){var a=jQuery(this),b=parseInt(a.data("id"));return b>0&&(a.data("status","inprogress"),jQuery("span",jQuery(this)).addClass("fa-x--hover"),evo_rest_api_request("collections/"+a.data("coll")+"/items/"+b+"/flag",function(b){b.flag?(a.find("span:first").show(),a.find("span:last").hide()):(a.find("span:last").show(),a.find("span:first").hide()),jQuery("span",a).removeClass("fa-x--hover"),setTimeout(function(){a.removeData("status")},500)})),!1}),jQuery(document).on("mouseover","a.evo_post_flag_btn",function(){"inprogress"!=jQuery(this).data("status")&&jQuery("span",jQuery(this)).addClass("fa-x--hover")}),jQuery(document).on("click","span.evo_post_resolve_btn a",function(){var a=jQuery(this).parent(),b=parseInt(a.data("id")),c=void 0===a.data("cmt-id")?0:parseInt(a.data("cmt-id"));return b>0&&(a.data("status","inprogress"),jQuery("a span",a).addClass("fa-x--hover"),evo_rest_api_request("collections/"+a.data("coll")+"/items/"+b+"/resolve/"+c,function(d){d.resolved_cmt_ID==c?(jQuery("span.evo_post_resolve_btn[data-id="+b+"]").each(function(){void 0===jQuery(this).data("cmt-id")?jQuery(this).find(" a:first").hide().next().show():jQuery(this).find(" a:first").show().next().hide()}),a.find("a:first").hide().next().show()):jQuery("span.evo_post_resolve_btn[data-id="+b+"]").find("a:first").show().next().hide(),jQuery("a span",a).removeClass("fa-x--hover"),setTimeout(function(){a.removeData("status")},500)},"POST")),!1}),jQuery(document).on("mouseover","span.evo_post_resolve_btn a",function(){var a=jQuery(this).parent();"inprogress"!=a.data("status")&&jQuery("a span",a).addClass("fa-x--hover")}),jQuery(document).ready(function(){if(jQuery("#attachments_fieldset_table").length>0){var a=jQuery("#attachments_fieldset_table").height();a=a>320?320:a<97?97:a,jQuery("#attachments_fieldset_wrapper").height(a),jQuery("#attachments_fieldset_wrapper").resizable({minHeight:80,handles:"s",resize:function(a,b){jQuery("#attachments_fieldset_wrapper").resizable("option","maxHeight",jQuery("#attachments_fieldset_table").height())}}),jQuery(document).on("click","#attachments_fieldset_wrapper .ui-resizable-handle",function(){var a=jQuery("#attachments_fieldset_table").height(),b=jQuery("#attachments_fieldset_wrapper").height()+80;jQuery("#attachments_fieldset_wrapper").css("height",b>a?a:b)})}});