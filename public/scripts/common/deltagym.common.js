commonRegex = function(){
    this.name = /^[áéíóúñA-Za-z\s]{3,20}$/;
    this.stringOptional = /^([áéíóúñA-Za-z\s]{3,30})?$/;
    this.email = /^(([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?))?$/i;
    this.requiredNumber = /^[0-9]{1,4}$/;
    this.requiredNumberLength5 = /^[0-9]{1,5}$/;
}

function AjaxRequest(){

	var Configuration = null;
	var _this = this;

	this.request = function(configuration){
		_this.Configuration = configuration;
    if(_this.Configuration.showLoading){
      _this.showLoading();
    }
    $.ajax({
            type: "POST",
            url: _this.Configuration.URL,
            data: _this.Configuration.data,
            async:_this.Configuration.asign,
            }).done(function(response) {
                _this.hideLoading();
                if(_this.Configuration.callBack!=null){
                    _this.Configuration.callBack(response);
                }
            })
            .fail(function(errorResponse) {
                _this.hideLoading();
                alert(errorResponse.responseText);
            });
	}
  this.showLoading = function(){
    var html= "<div id='loading'>"+
              "<table>"+
              "<tr>"+
              "<td>"+
              "<img src='img/default/loading.gif' /></td><td><span>Cargando</span></td></tr></table></div>";
    $('body').append(html);
    $("#loading").dialog({
        modal:true,
        width:200,
        height:110,
        resizable:false,
        open: function(event, ui) { $(".ui-dialog-titlebar").hide(); }
    });
  }

  this.hideLoading = function(){
    if($("#loading").length>0){
      $("#loading").dialog('close');
      $("#loading").remove();
    }
  }
}

function validateFields(containerName,className){
    var validFields = true;
    $.each($("#"+containerName+" ."+className),function(i, e){
        if(!$(e).val().match(eval($(e).attr('regex')))){
            validFields = false;
            appendError($(e),"<span class='error' style='font-size:.7rem;color:red'>Dato invalido o requerido</span>");
            $(e).css("border","2px dashed red");
            $(e).css("background-color","#F0DA95");
        }else{
            $(e).parent().find(".error").remove();
            $(e).css("border","1px solid #ccc");
            $(e).css("background-color","#FFFFFF");
        }
    });
    return validFields;
}

function appendError($element,msg){
    $element.parent().find(".error").remove();
    $element.parent().append("<span class='error' style='font-size:.7rem;color:red'><br>"+msg+"</span>");
}

function removeError($element){
    $element.parent().find(".error").remove();
}

function showMsg(msg){
    $("#dialogMsg").text(msg);
    $("#dialog").dialog({
        title:'Mensaje',
        modal:true,
        width:400,
        height:200,
        resizable:false,
        buttons: {
            OK: function(){
                $(this).dialog("close");
                $(".firstFocus").focus();
            }
        }
    });
}

function myunescape (str)
{
    str = "" + str;
    while (true)
    {
        var i = str . indexOf ('+');
        if (i < 0)
            break;
        str = str . substring (0, i) + '%20' +
            str . substring (i + 1, str . length);
    }
    return unescape (str);
}

function validateFileSize(component,maxSize)
{
   if(navigator.appName=="Microsoft Internet Explorer")
   {
      if(component.value)
      {
         var oas=new ActiveXObject("Scripting.FileSystemObject");
         var e=oas.getFile(component.value);
         var size=e.size;
      }
   }
   else
   {
      if(component.files[0]!=undefined)
      {
         size = component.files[0].size;
      }
   }
   if(size!=undefined && size>maxSize)
   {
      component.value="";
      return false;
   }
   else
   {
      return true;
   }
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function getCurrentUserDate(){
  var date;
  date = new Date();
  date = date.getFullYear() + '-' +
      ('00' + (date.getMonth()+1)).slice(-2) + '-' +
      ('00' + date.getDate()).slice(-2) + ' ' + 
      ('00' + date.getHours()).slice(-2) + ':' + 
      ('00' + date.getMinutes()).slice(-2) + ':' + 
      ('00' + date.getSeconds()).slice(-2);
  return date;
}

function getCurrentUTCDate(){
  var date;
  date = new Date();
  date = date.getUTCFullYear() + '-' +
    ('00' + (date.getUTCMonth()+1)).slice(-2) + '-' +
    ('00' + date.getUTCDate()).slice(-2) + ' ' + 
    ('00' + date.getUTCHours()).slice(-2) + ':' + 
    ('00' + date.getUTCMinutes()).slice(-2) + ':' + 
    ('00' + date.getUTCSeconds()).slice(-2);
  return date;
}

function askDialog(){
  
  var _this = null;
  var config

  this.open = function(configuration){
    $("#askDialog").remove();
    _this = this;
    _this.config = configuration;
    _this.ini();
    $("#askDialog").dialog({
          title:_this.config.title,
          modal:true,
          width:400,
          height:250,
          resizable:false,
          buttons: _this.config.buttons
      });
  }

  this.ini = function(){
    _this.generateHTML();
  }

  this.generateHTML = function(){
    var html = "<div id='askDialog'>";
    html += "<span>"+_this.config.msg+"</span>";
    html += "</div>";
    $('body').append(html);
  }

}