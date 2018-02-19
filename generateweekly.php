<!DOCTYPE html>
<html>
<head>
<script src="js/jquery-2.2.4.min.js"></script>
<script src="js/bootstrap.js"></script>

<link rel="stylesheet" href="bootstrap.css">
<title>Generate Weekly Report</title>
</head>

<style>
    body {
        margin-top: 30px;
    }
    #tableResult {
        margin: 30px 0;
    }
    #tableResult td { 
        padding: 5px;
    }
    #clearShit, #clear {
        float:right;
    }
    #addEmptyRow {
        margin-left: 15px;
    }
    #tableResult .remove {
        padding: 4px 11px;
        margin-top: 10px;
        position: absolute;
        left: 118px;
        top: -2px;
    }
    #fileName {
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    #fileName:focus {
        color: #495057;
        background-color: #fff;
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    .copyFileName {
        float: left; 
        margin-right: 15px;
        position: relative;
    }
    .valid-tooltip {
        position: absolute;
        top: -80%;
        z-index: 5;
        display: none;
        max-width: 100%;
        padding: .5rem;
        margin-top: .1rem;
        font-size: .875rem;
        line-height: 1;
        color: #fff;
        background-color: rgba(40,167,69,.8);
        border-radius: .2rem;
    }
</style>

<body>
    <div class="container">
        <div class="form-group">
            <label for="names">Who the heck?</label>
            <select class="form-control" id="names">
                <option value="Kevin Koh">Kevin</option>
                <option value="Nwe Win">Win</option>
                <option value="Eugenia">Eugenia</option>
                <option value="Yi Wei">Yi Wei</option>
                <option value="Daniel">Daniel</option>
            </select>
        </div>
        <form id="submitForm"></form>
            <div class="form-group">
                <label for="tasks">Tasks: </label>
                <textarea class="form-control" id="tasks" rows="6"></textarea>
            </div>
            <button type="button" id="formSubmit" class="btn btn-info">Create Table</button>
            <button type="button" id="addEmptyRow" class="btn btn-warning">Add Empty Row</button>
            <button type="button" id="clear" class="btn btn-danger">Clear Field</button>
        </form>
        <table id="tableResult"> 
            <thead>
                <tr>
                    <td class="xl89" width="73" style="font-size:13px;font-family:arial;width:60pt;background:#B7B7B7;color:black;
        font-weight:700;border:.5pt solid windowtext;vertical-align:top;">日期<br style="mso-data-placement:same-cell;"/>
                    Date</td>
                    <td class="xl89" width="94" style="font-size:13px;font-family:arial;border-left:none;width:71pt;background:#B7B7B7;color:black;
        font-weight:700;border:.5pt solid windowtext;vertical-align:top;">部门<br style="mso-data-placement:same-cell;"/>
                    Department</td>
                    <td class="xl89" width="196" style="font-size:13px;font-family:arial;border-left:none;width:147pt;background:#B7B7B7;color:black;
        font-weight:700;border:.5pt solid windowtext;vertical-align:top;">存在的问题及对策 <br style="mso-data-placement:same-cell;"/>
                    Existing Problems &amp; Solutions</td>
                    <td class="xl89" width="261" style="font-size:13px;font-family:arial;border-left:none;width:196pt;background:#B7B7B7;color:black;
        font-weight:700;border:.5pt solid windowtext;vertical-align:top;">工作任务<br style="mso-data-placement:same-cell;"/>
                    Tasks</td>
                    <td class="xl89" width="193" style="font-size:13px;font-family:arial;border-left:none;width:145pt;background:#B7B7B7;color:black;
        font-weight:700;border:.5pt solid windowtext;vertical-align:top;">完成情况或所需资源<br style="mso-data-placement:same-cell;"/>
                    Progress/Required Resources</td>
                    <td class="xl89" width="138" style="font-size:13px;font-family:arial;border-left:none;width:104pt;background:#B7B7B7;color:black;
        font-weight:700;border:.5pt solid windowtext;vertical-align:top;">计划完成时间<br style="mso-data-placement:same-cell;"/>
                    Date of Planned Completion</td>
                    <td class="xl89" width="162" style="font-size:13px;font-family:arial;border-left:none;width:122pt;background:#B7B7B7;color:black;
        font-weight:700;border:.5pt solid windowtext;vertical-align:top;">经办人<br style="mso-data-placement:same-cell;"/>
                    Person in Charge</td>
                    <td class="xl89" width="114" style="font-size:13px;font-family:arial;border-left:none;width:86pt;background:#B7B7B7;color:black;
        font-weight:700;border:.5pt solid windowtext;vertical-align:top;">主管领导<br style="mso-data-placement:same-cell;"/>
                    Leader</td>
                    <td colspan="3" style="mso-ignore:colspan"></td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <button type="button" id="exportShit" class="btn btn-info">Export to Excel</button>
        <div class="copyFileName">
            <input type="text" value='Weekly Report_template' id="fileName">
            <div class="valid-tooltip">
                Copied liao
            </div>
        </div>
        <button type="button" id="clearShit" class="btn btn-danger">Clear Table</button>
        <a id="dlink"  style="display:none;"></a>
    </div>
</body>

<?php 
    date_default_timezone_set('Asia/Singapore');
?>
<script type="text/javascript">
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
        return function (table, name, filename) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

            document.getElementById("dlink").href = uri + base64(format(template, ctx));
            document.getElementById("dlink").download = filename;
            document.getElementById("dlink").click();

        }
    })()
    Array.prototype.clean = function(deleteValue) {
        for (var i = 0; i < this.length; i++) {
            if (this[i] == deleteValue) {         
                this.splice(i, 1);
                i--;
            }
        }
        return this;
    };
    function thisWeek(week, ongoing) {
        var tempStr;
        <?php
            $monday = strtotime("last monday");
            $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
        
            $friday = strtotime(date("Y-m-d",$monday)." +4 days");
            $nextfriday = strtotime(date("Y-m-d",$friday)." +1 week");
        
            $this_week_sd = date("Y-m-d",$monday);
            $this_week_ed = date("Y-m-d",$friday);
        ?>
        //generate the whole  current week
        if(week) {
            tempStr = '<?= $this_week_sd ?>' + '<br style="mso-data-placement:same-cell;"/>  - <br style="mso-data-placement:same-cell;"/> ' + '<?= $this_week_ed; ?>' + '<br style="mso-data-placement:same-cell;"/> ';
        }
        //if there are some tasks still ongoing, then set the date as next week
        else {
            if(ongoing) {
                tempStr = '<?= date("Y-m-d",$nextfriday); ?>';
            }
            else {
                tempStr = '<?= date("Y-m-d",$friday); ?>';
            }
        }
        return tempStr; 
    }
    function nextWeek() {
        var tempStr;
        <?php
            $monday = strtotime("next monday");
            $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
        
            $friday = strtotime(date("Y-m-d",$monday)." +4 days");
        ?>

        tempStr = '<?= date("Y-m-d",$monday); ?>' + '<br style="mso-data-placement:same-cell;"/>  - <br style="mso-data-placement:same-cell;"/> ' + '<?= date("Y-m-d",$friday); ?>' + '<br style="mso-data-placement:same-cell;"/> ';
        
        return tempStr; 
    }
    function task(str) {
        var tempStr;
        
        var date = thisWeek(1, 0);
        if(str.toLowerCase().includes('next')) {
            date = nextWeek();
        }

        tempStr = '<tr>'+
            '<td contenteditable="true" class="xl91" style="font-size:13px;font-family:arial;mso-style-parent:style0;text-align:left;vertical-align:top;border-top:none;border-right:.5pt solid black;	border-bottom:.5pt solid black;	border-left:.5pt solid black;background:yellow;	mso-pattern:yellow none;">'+date+'</td>'+
            '<td contenteditable="true" class="xl75" style="font-size:13px;font-family:arial;border-left:none;text-align:left;	vertical-align:top;	border-top:none;	border-right:.5pt solid black;	border-bottom:.5pt solid black;	border-left:.5pt solid black;">IT e-commerce</td>'+
            '<td contenteditable="true" class="xl76" style="font-size:13px;font-family:arial;border-left:none;border-top:none;	border-right:none;	border-bottom:.5pt solid black;	border-left:.5pt solid black;"></td>'+
            '<td contenteditable="true" class="xl77" width="261" style="font-size:13px;font-family:arial;width:196pt;text-align:left;vertical-align:top;border-top:none;	border-right:.5pt solid windowtext;	border-bottom:.5pt solid windowtext;border-left:.5pt solid windowtext;	white-space:normal;"><b>'+str+'\'s Tasks'+'</b> ';
        return tempStr;
    }
    function endTask(status) {
        var tempStr, dateStr = '';
        tempStr = '<td contenteditable="true" class="xl92" width="193" style="font-size:13px;font-family:arial;border-left:none;width:145pt;text-align:left;vertical-align:top;border-top:.5pt solid black;border-right:none;border-bottom:0.5pt solid windowtext;border-left:.5pt solid black;">';
        if(status != '') {
            if(status.length > 0) {
                for(var i=0; i<status.length;i++) {
                    tempStr +=  status[i] + '<br style="mso-data-placement:same-cell;"/> ';
                    if(status[i].toLowerCase() == 'ongoing' || status[i].toLowerCase() == '(ongoing)' || status[i].toLowerCase() == '(in progress)' || status[i].toLowerCase() == 'in progress' || status[i].toLowerCase() == 'todo' ) {
                        dateStr += thisWeek(false, 1) + '<br style="mso-data-placement:same-cell;"/> ';
                    }
                    else { 
                        dateStr += thisWeek(false, 0) + '<br style="mso-data-placement:same-cell;"/> ';
                    }
                }
            }
            else {
                tempStr += status[0];
                if(status[0].toLowerCase() == 'ongoing' || status[0].toLowerCase() == '(ongoing)' || status[0].toLowerCase() == '(in progress)' || status[0].toLowerCase() == 'in progress' || status[0].toLowerCase() == 'todo' ) {
                    dateStr += thisWeek(false, 1) + '<br style="mso-data-placement:same-cell;"/> ';
                }
                else {
                    dateStr += thisWeek(false, 0) + '<br style="mso-data-placement:same-cell;"/> ';
                }

            }
        } else {
            tempStr += 'Todo';
            dateStr += thisWeek(false, 1) + '<br style="mso-data-placement:same-cell;"/> ';
        }
        tempStr += '</td>';
        tempStr += '<td contenteditable="true" class="xl92" width="193" style="font-size:13px;font-family:arial;border-left:none;width:145pt;text-align:left;vertical-align:top;border-top:.5pt solid black;border-right:none;border-bottom:0.5pt solid windowtext;border-left:.5pt solid black;">'+dateStr+'</td>';
        
        tempStr += '<td contenteditable="true" class="xl92" width="193" style="font-size:13px;font-family:arial;border-left:none;width:145pt;text-align:left;vertical-align:top;border-top:.5pt solid black;border-right:none;border-bottom:0.5pt solid windowtext;border-left:.5pt solid black;">'+$('#names').val() +'</td>' + 
        '<td contenteditable="true" class="xl75" style="font-size:13px;font-family:arial;position: relative; border-left:none;text-align:left;vertical-align:top;	border-top:.5pt solid black; border-right:.5pt solid black;border-bottom:0.5pt solid windowtext;border-left:.5pt solid black;">Wang XiaoFei <br style="mso-data-placement:same-cell;"/> <button type="button" class="remove btn btn-sm btn-danger">X</button></td></tr>';

        return tempStr; 
    }
    function addEmpty() {
        var tempStr;
        tempStr += task('Today');
        tempStr += endTask('');
        $('#tableResult tbody').append(tempStr);
    }
    $(document).ready(function() {
        $( "#fileName" ).focus(function() {
            /* Select the text field */
            this.select();
            /* Copy the text inside the text field */
            document.execCommand("Copy");
            $('.copyFileName > .valid-tooltip').show();
        });
        $( "#fileName" ).blur(function() {
            $('.copyFileName > .valid-tooltip').hide();
        });
        $('#exportShit').off().on('click', function(e){
            $('.remove').remove();
            var str = document.getElementById('tableResult').innerHTML;
            document.getElementById('tableResult').innerHTML = str.replace(/<br\s*[\/]?>/gi, '<br style="mso-data-placement:same-cell;">');
            tableToExcel('tableResult', '<?= date("Y-m-d"); ?>', 'Weekly Report_template.xls');
        });
        $('#clearShit').off().on('click', function(e){
            $("#tableResult > tbody").html("");
        });
        $('#clear').off().on('click', function(e){
            $("#tasks").val('');
        });
        $('#addEmptyRow').off().on('click', function(e){
            addEmpty();
        });
        $('#tableResult tbody').off().on('click', 'button.remove', function(e){
            $(this).parents('tr').remove();
        });

        $('#formSubmit').off().on('click', function(e){
            var tasks = $('#tasks').val(); 
            var name, todayEnd = false; 
            var items = tasks.split("\n").clean("");
            var statuses = ['done', 'completed', 'ongoing', '(on going)', 'on-going', 'todo', 'to do', '(done)', '(ongoing)', 'in progress', '(in progress)', '(to do)']; 
            var itemsStatus = [], tableStr = '';

            if(tasks == '') {
                addEmpty();
            }
            else {
                for(var i=0; i<items.length;i++) {
                    items[i] = items[i].replace(/-/g, "").toLowerCase();
                    if(items[i].includes('tomorrow') || items[i].includes('next')) {
                        tableStr += endTask(itemsStatus);
                        itemsStatus = [];
                        tableStr += task('Next Week');
                    }
                    else if(items[i].includes('today') || items[i].includes('this') || items[i].includes('current')) {
                        tableStr += task('This Week');
                    }
                    else {
                        //to check if status is one line with task
                        tableStr += '<br style="mso-data-placement:same-cell;"/> ';
                        var temp = items[i].match(/(\([^\)]+\)|\S+|\s+)/g).clean(" ");
                        for(var j=0; j<temp.length;j++) {
                            //if bo status inside
                            if(statuses.indexOf(temp[j]) == -1) {
                                tableStr +=  temp[j] + ' ';
                            }
                            else if(statuses.indexOf(temp[j]) > -1) {
                                //if gpt status then save it for next column
                                temp[j] = temp[j].replace(/(\(|\))/g, '').replace(' ', '');
                                itemsStatus.push(capitalizeFirstLetter(temp[j]));
                            }
                        }
                    }
                }      
                tableStr += endTask(itemsStatus);
                $('#tableResult tbody').append(tableStr);
            }
        });
    });
</script>

</html>