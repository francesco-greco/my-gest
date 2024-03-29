<!DOCTYPE HTML>
<html>
   <head>
      <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
      <title>Gantt - <?php echo $project->name. " ({$project->code})" ?></title>

      <script src="<?php print_url('js/ch_serverside_constants.js.php') ?>"></script>
      <link rel=stylesheet href="<?php print_url('js/plugin/jQueryGantt/platform.css') ?>" type="text/css">
      <link rel=stylesheet href="<?php print_url('js/plugin/jQueryGantt/libs.pack.min.css') ?>" type="text/css">

      <link rel=stylesheet href="<?php print_url('js/plugin/jQueryGantt/gantt.css') ?>" type="text/css">
      <!--<link rel=stylesheet href="<?php print_url('js/plugin/jQueryGantt/ganttPrint.css') ?>" type="text/css" media="print">-->
      <script>
         var base_url = '<?php echo $base_url ?>';
         <?php if(isset($this->bitauth->preferred_lang)) : ?>
         var lang = '<?php echo $this->bitauth->preferred_lang ?>';
         <?php endif; ?>
         var dictionary = <?php if(isset($dictionary) && is_array($dictionary)) { echo json_encode($dictionary); } else { echo '{}'; }?>;
         var res_folder = base_url + 'js/plugin/jQueryGantt/res';
         var id_project = '<?php echo $project->id?>';
      </script>
      <script src="<?php print_url('js/vendor/jquery.js') ?>"></script>
      <script src="<?php print_url('js/vendor/jquery-migrate.min.js') ?>"></script>
      <script src="<?php print_url('js/vendor/jquery-ui-1.9.2.custom.min.js') ?>"></script>

      <script src="<?php print_url('js/plugin/jQueryGantt/libs.pack.min.js') ?>"></script>
      <script src="<?php print_url('js/plugin/jQueryGantt/libs/i18nJs.js') ?>"></script>

      <script src="<?php print_url('js/plugin/jQueryGantt/ganttUtilities.js') ?>"></script>
      <script src="<?php print_url('js/plugin/jQueryGantt/ganttTask.js') ?>"></script>
      <script src="<?php print_url('js/plugin/jQueryGantt/ganttDrawerSVG.js') ?>"></script>
      <!--<script src="ganttDrawer.js"></script>-->
      <script src="<?php print_url('js/plugin/jQueryGantt/ganttGridEditor.js') ?>"></script>
      <script src="<?php print_url('js/plugin/jQueryGantt/ganttMaster.js') ?>"></script>  
      
   </head>
   <body style="background-color: #fff;">

      <div id="workSpace" style="padding:0px; overflow-y:auto; overflow-x:hidden;border:1px solid #e5e5e5;position:relative;margin:0 5px"></div>

      <div id="gantEditorTemplates" style="display:none;">
        <div class="__template__" data-type="GANTBUTTONS"><!--
        <div class="ganttButtonBar noprint">
          <div class="buttons">
          <button onclick="$('#workSpace').trigger('undo.gantt');" class="button textual" title="undo"><span class="teamworkIcon">&#39;</span></button>
          <button onclick="$('#workSpace').trigger('redo.gantt');" class="button textual" title="redo"><span class="teamworkIcon">&middot;</span></button>
          <span class="ganttButtonSeparator"></span>
          <button onclick="$('#workSpace').trigger('addAboveCurrentTask.gantt');" class="button textual" title="insert above"><span class="teamworkIcon">l</span></button>
          <button onclick="$('#workSpace').trigger('addBelowCurrentTask.gantt');" class="button textual" title="insert below"><span class="teamworkIcon">X</span></button>
          <span class="ganttButtonSeparator"></span>
          <button onclick="$('#workSpace').trigger('indentCurrentTask.gantt');" class="button textual" title="indent task"><span class="teamworkIcon">.</span></button>
          <button onclick="$('#workSpace').trigger('outdentCurrentTask.gantt');" class="button textual" title="unindent task"><span class="teamworkIcon">:</span></button>
          <span class="ganttButtonSeparator"></span>
          <button onclick="$('#workSpace').trigger('moveUpCurrentTask.gantt');" class="button textual" title="move up"><span class="teamworkIcon">k</span></button>
          <button onclick="$('#workSpace').trigger('moveDownCurrentTask.gantt');" class="button textual" title="move down"><span class="teamworkIcon">j</span></button>
          <span class="ganttButtonSeparator"></span>
          <button onclick="$('#workSpace').trigger('zoomMinus.gantt');" class="button textual" title="zoom out"><span class="teamworkIcon">)</span></button>
          <button onclick="$('#workSpace').trigger('zoomPlus.gantt');" class="button textual" title="zoom in"><span class="teamworkIcon">(</span></button>
          <span class="ganttButtonSeparator"></span>
          <button onclick="$('#workSpace').trigger('deleteCurrentTask.gantt');" class="button textual" title="delete"><span class="teamworkIcon">&cent;</span></button>
          <span class="ganttButtonSeparator"></span>
          <button onclick="print();" class="button textual" title="print"><span class="teamworkIcon">p</span></button>
          <span class="ganttButtonSeparator"></span>
          <button onclick="ge.gantt.showCriticalPath=!ge.gantt.showCriticalPath; ge.redraw();" class="button textual" title="Critical Path"><span class="teamworkIcon">&pound;</span></button>
          <span style="display:none;" class="ganttButtonSeparator"></span>
          <button style="display:none;" onclick="editResources();" class="button textual" title="edit resources"><span class="teamworkIcon">M</span></button>
            &nbsp; &nbsp; &nbsp; &nbsp;
            <button onclick="CH_Gantt.save();" class="button first big" title="save">save</button>
          </div></div>
        --></div>

        <div class="__template__" data-type="TASKSEDITHEAD"><!--
        <table class="gdfTable" cellspacing="0" cellpadding="0">
          <thead>
          <tr style="height:40px">
            <th class="gdfColHeader" style="width:35px;"></th>
            <th class="gdfColHeader" style="width:25px;"></th>
            <th class="gdfColHeader gdfResizable" style="width:30px;">code/short name</th>

            <th class="gdfColHeader gdfResizable" style="width:300px;">name</th>
            <th class="gdfColHeader gdfResizable" style="width:80px;">start</th>
            <th class="gdfColHeader gdfResizable" style="width:80px;">end</th>
            <th class="gdfColHeader gdfResizable" style="width:50px;">dur.</th>
            <th class="gdfColHeader gdfResizable" style="width:50px;">dep.</th>
            <th class="gdfColHeader gdfResizable" style="width:200px;">assignees</th>
          </tr>
          </thead>
        </table>
        --></div>

        <div class="__template__" data-type="TASKROW"><!--
        <tr taskId="(#=obj.id#)" class="taskEditRow" level="(#=level#)">
          <th class="gdfCell edit" align="right" style="cursor:pointer;"><span class="taskRowIndex">(#=obj.getRow()+1#)</span> <span class="teamworkIcon" style="font-size:12px;" >e</span></th>
          <td class="gdfCell noClip" align="center"><div class="taskStatus cvcColorSquare" status="(#=obj.status#)"></div></td>
          <td class="gdfCell"><input type="text" name="code" value="(#=obj.code?obj.code:''#)"></td>
          <td class="gdfCell indentCell" style="padding-left:(#=obj.level*10#)px;">
            <div class="(#=obj.isParent()?'exp-controller expcoll exp':'exp-controller'#)" align="center"></div>
            <input type="text" name="name" value="(#=obj.name#)">
          </td>

          <td class="gdfCell"><input type="text" name="start"  value="" class="date"></td>
          <td class="gdfCell"><input type="text" name="end" value="" class="date"></td>
          <td class="gdfCell"><input type="text" name="duration" value="(#=obj.duration#)"></td>
          <td class="gdfCell"><input type="text" name="depends" value="(#=obj.depends#)" (#=obj.hasExternalDep?"readonly":""#)></td>
          <td class="gdfCell taskAssigs">(#=obj.getAssigsString()#)</td>
        </tr>
        --></div>

        <div class="__template__" data-type="TASKEMPTYROW"><!--
        <tr class="taskEditRow emptyRow" >
          <th class="gdfCell" align="right"></th>
          <td class="gdfCell noClip" align="center"></td>
          <td class="gdfCell"></td>
          <td class="gdfCell"></td>
          <td class="gdfCell"></td>
          <td class="gdfCell"></td>
          <td class="gdfCell"></td>
          <td class="gdfCell"></td>
          <td class="gdfCell"></td>
        </tr>
        --></div>

        <div class="__template__" data-type="TASKBAR"><!--
        <div class="taskBox taskBoxDiv" taskId="(#=obj.id#)" >
          <div class="layout (#=obj.hasExternalDep?'extDep':''#)">
            <div class="taskStatus" status="(#=obj.status#)"></div>
            <div class="taskProgress" style="width:(#=obj.progress>100?100:obj.progress#)%; background-color:(#=obj.progress>100?'red':'rgb(153,255,51);'#);"></div>
            <div class="milestone (#=obj.startIsMilestone?'active':''#)" ></div>

            <div class="taskLabel"></div>
            <div class="milestone end (#=obj.endIsMilestone?'active':''#)" ></div>
          </div>
        </div>
        --></div>

        <div class="__template__" data-type="CHANGE_STATUS"><!--
          <div class="taskStatusBox">
            <div class="taskStatus cvcColorSquare" status="STATUS_ACTIVE" title="active"></div>
            <div class="taskStatus cvcColorSquare" status="STATUS_DONE" title="completed"></div>
            <div class="taskStatus cvcColorSquare" status="STATUS_FAILED" title="failed"></div>
            <div class="taskStatus cvcColorSquare" status="STATUS_SUSPENDED" title="suspended"></div>
            <div class="taskStatus cvcColorSquare" status="STATUS_UNDEFINED" title="undefined"></div>
          </div>
        --></div>


        <div class="__template__" data-type="TASK_EDITOR"><!--
        <div class="ganttTaskEditor">
        <table width="100%">
          <tr>
            <td>
              <table cellpadding="5">
                <tr>
                  <td><label for="code">code/short name</label><br><input type="text" name="code" id="code" value="" class="formElements"></td>
                 </tr><tr>
                  <td><label for="name">name</label><br><input type="text" name="name" id="name" value=""  size="35" class="formElements"></td>
                </tr>
                <tr></tr>
                  <td>
                    <label for="description">description</label><br>
                    <textarea rows="5" cols="30" id="description" name="description" class="formElements"></textarea>
                  </td>
                </tr>
              </table>
            </td>
            <td valign="top">
              <table cellpadding="5">
                <tr>
                <td colspan="2"><label for="status">status</label><br><div id="status" class="taskStatus" status=""></div></td>
                <tr>
                <td colspan="2"><label for="progress">progress</label><br><input type="text" name="progress" id="progress" value="" size="3" class="formElements"></td>
                </tr>
                <tr>
                <td><label for="start">start</label><br><input type="text" name="start" id="start"  value="" class="date" size="10" class="formElements"><input type="checkbox" id="startIsMilestone"> </td>
                <td rowspan="2" class="graph" style="padding-left:50px"><label for="duration">dur.</label><br><input type="text" name="duration" id="duration" value=""  size="5" class="formElements"></td>
              </tr><tr>
                <td><label for="end">end</label><br><input type="text" name="end" id="end" value="" class="date"  size="10" class="formElements"><input type="checkbox" id="endIsMilestone"></td>
              </table>
            </td>
          </tr>
          </table>

        <h2>assignments</h2>
        <table  cellspacing="1" cellpadding="0" width="100%" id="assigsTable">
          <tr>
            <th style="width:100px;">name</th>
            <th style="width:70px;">role</th>
            <th style="width:30px;">est.wklg.</th>
            <th style="width:30px;" id="addAssig"><span class="teamworkIcon" style="cursor: pointer">+</span></th>
          </tr>
        </table>

        <div style="text-align: right; padding-top: 20px"><button id="saveButton" class="button big">save</button></div>
        </div>
        --></div>


        <div class="__template__" data-type="ASSIGNMENT_ROW"><!--
        <tr taskId="(#=obj.task.id#)" assigId="(#=obj.assig.id#)" class="assigEditRow" >
          <td ><select name="resourceId"  class="formElements" (#=obj.assig.id.indexOf("tmp_")==0?"":"disabled"#) ></select></td>
          <td ><select type="select" name="roleId"  class="formElements"></select></td>
          <td ><input type="text" name="effort" value="(#=getMillisInHoursMinutes(obj.assig.effort)#)" size="5" class="formElements"></td>
          <td align="center"><span class="teamworkIcon delAssig" style="cursor: pointer">d</span></td>
        </tr>
        --></div>


        <div class="__template__" data-type="RESOURCE_EDITOR"><!--
        <div class="resourceEditor" style="padding: 5px;">

          <h2>Project team</h2>
          <table  cellspacing="1" cellpadding="0" width="100%" id="resourcesTable">
            <tr>
              <th style="width:100px;">name</th>
              <th style="width:30px;" id="addResource"><span class="teamworkIcon" style="cursor: pointer">+</span></th>
            </tr>
          </table>

          <div style="text-align: right; padding-top: 20px"><button id="resSaveButton" class="button big">save</button></div>
        </div>
        --></div>


        <div class="__template__" data-type="RESOURCE_ROW"><!--
        <tr resId="(#=obj.id#)" class="resRow" >
          <td ><input type="text" name="name" value="(#=obj.name#)" style="width:100%;" class="formElements"></td>
          <td align="center"><span class="teamworkIcon delRes" style="cursor: pointer">d</span></td>
        </tr>
        --></div>
      </div>
      <script src="<?php print_url('js/med_chhab_app.js') ?>"></script>
      <script src="<?php print_url('js/plugin/jQueryGantt/main.js') ?>"></script>
   </body>
</html>