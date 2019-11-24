var CH_Gantt = (function () {
   var ge,
   messages = {
//      it: {
        "CANNOT_WRITE": CH_Tools.lang('gantt_cannot_write_msg'),
        "CHANGE_OUT_OF_SCOPE": CH_Tools.lang('gantt_change_out_of_scope_msg'),
        "START_IS_MILESTONE": CH_Tools.lang('gantt_start_is_milestone_msg'),
        "END_IS_MILESTONE": CH_Tools.lang('gantt_end_is_milestone_msg'),
        "TASK_HAS_CONSTRAINTS": CH_Tools.lang('gantt_task_has_constraints_msg'),
        "GANTT_ERROR_DEPENDS_ON_OPEN_TASK": CH_Tools.lang('gantt_gantt_error_depends_on_open_task_msg'),
        "GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK": CH_Tools.lang('gantt_gantt_error_descendant_of_closed_task_msg'),
        "TASK_HAS_EXTERNAL_DEPS": CH_Tools.lang('gantt_task_has_external_deps_msg'),
        "GANTT_ERROR_LOADING_DATA_TASK_REMOVED": CH_Tools.lang('gantt_gantt_error_loading_data_task_removed_msg'),
        "ERROR_SETTING_DATES": CH_Tools.lang('gantt_error_setting_dates_msg'),
        "CIRCULAR_REFERENCE": CH_Tools.lang('gantt_circular_reference_msg'),
        "CANNOT_DEPENDS_ON_ANCESTORS": CH_Tools.lang('gantt_cannot_depends_on_ancestors_msg'),
        "CANNOT_DEPENDS_ON_DESCENDANTS": CH_Tools.lang('gantt_cannot_depends_on_descendants_msg'),
        "INVALID_DATE_FORMAT": CH_Tools.lang('gantt_invalid_date_format_msg'),
        "TASK_MOVE_INCONSISTENT_LEVEL": CH_Tools.lang('gantt_task_move_inconsistent_level_msg'),
        "TASK_THAT_WILL_BE_REMOVED": CH_Tools.lang('gantt_task_that_will_be_removed_msg')
     };
   
   function init() {
      //load templates
      $("#ganttemplates").loadTemplates();

      // here starts gantt initialization
      ge = new GanttMaster();
      var workSpace = $("#workSpace");
      workSpace.css({width:$(window).width() - 20,height:$(window).height() - 100});
      ge.init(workSpace);

      //inject some buttons (for this demo only)
//      $(".ganttButtonBar div").addClass('buttons').append("<button onclick='clearGantt();' class='button'>clear</button>");
      //overwrite with localized ones

      loadI18n();
      loadGanttFromServer();


      //fill default Teamwork roles if any
      if (!ge.roles || ge.roles.length == 0) {
      //          setRoles();
      }

      //fill default Resources roles if any
      if (!ge.resources || ge.resources.length == 0) {
      //          setResource();
      }

      $(window).resize(function(){
         workSpace.css({width:$(window).width() - 1,height:$(window).height() - workSpace.position().top});
         workSpace.trigger("resize.gantt");
      }).oneTime(150, "resize", function(){ $(this).trigger("resize"); });
   }
   
   function loadGanttFromServer(taskId, callback) {
      $.getJSON(base_url + CH_URL.projects + "/ajax_load_manager_gantt/" + id_project, function(response) {
         if (response.ok) {
            ge.loadProject(response.project);
            ge.checkpoint(); //empty the undo stack

            if (typeof(callback)=="function") {
               callback(response);
            }
         } else {
            jsonErrorHandling(response);
         }
      });
   }

   function saveGanttOnServer() {
      if(!ge.canWrite) return;

      var prj = ge.saveProject();
      delete prj.resources;
      delete prj.roles;

      if (ge.deletedTaskIds.length > 0) {
         if (!confirm(CH_Tools.printf(messages["TASK_THAT_WILL_BE_REMOVED"], ge.deletedTaskIds.length))) {
            return;
         }
      }

      $.ajax(base_url + CH_URL.projects + "/ajax_save_manager_gantt/" + id_project, {
         dataType:"json",
         data: {prj:JSON.stringify(prj)},
         type:"POST",

         success: function(response) {
            if (response.ok) {
               if (response.project) {
                  ge.loadProject(response.project); //must reload as "tmp_" ids are now the good ones
               } else {
                  ge.reset();
               }
            } else {
               var errMsg="Errors saving project\n";
               if (response.message) {
                  errMsg=errMsg+response.message+"\n";
               }

               if (response.errorMessages.length) {
                  errMsg += response.errorMessages.join("\n");
               }

               alert(errMsg);
            }
         }
      });
   }


   //-------------------------------------------  Create some demo data ------------------------------------------------------
   function clearGantt() {
     ge.reset();
   }

   function loadI18n() {
      GanttMaster.messages = messages;
   }

   return {
      init: init,
      save: saveGanttOnServer
   };
})();
$(CH_Gantt.init());


      
      
      
      
      //OLD ASSIGMENT METHOD
/*$.JST.loadDecorator("ASSIGNMENT_ROW", function(assigTr, taskAssig) {

   var resEl = assigTr.find("[name=resourceId]");
   for (var i in taskAssig.task.master.resources) {
      var res = taskAssig.task.master.resources[i];
      var opt = $("<option>");
      opt.val(res.id).html(res.name);
      if (taskAssig.assig.resourceId == res.id)
        opt.attr("selected", "true");
      resEl.append(opt);
   }


   var roleEl = assigTr.find("[name=roleId]");
   for (var i in taskAssig.task.master.roles) {
      var role = taskAssig.task.master.roles[i];
      var optr = $("<option>");
      optr.val(role.id).html(role.name);
      if (taskAssig.assig.roleId == role.id)
        optr.attr("selected", "true");
      roleEl.append(optr);
   }

   if(taskAssig.task.master.canWrite && taskAssig.task.canWrite) {
      assigTr.find(".delAssig").click(function() {
        var tr = $(this).closest("[assigId]").fadeOut(200, function() {
          $(this).remove();
        });
      });
   }
});*/