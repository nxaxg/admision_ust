/*!
 *  Copyright (c) 2009 Jos� Joaqu�n N��ez (josejnv@gmail.com) http://joaquinnunez.cl/blog/
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-2.0.php)
 * Use only for non-commercial usage.
 *
 * Version : 0.5
 *
 * Requires: jQuery 1.2+
 */
(function(a){jQuery.fn.Rut=function(b){var d={digito_verificador:null,on_error:function(){},on_success:function(){},validation:true,format:true,format_on:"change"};var c=a.extend(d,b);return this.each(function(){if(d.format){jQuery(this).bind(d.format_on,function(){jQuery(this).val(jQuery.Rut.formatear(jQuery(this).val(),d.digito_verificador==null))})}if(d.validation){if(d.digito_verificador==null){jQuery(this).bind("blur",function(){var f=jQuery(this).val();if(jQuery(this).val()!=""&&!jQuery.Rut.validar(f)){d.on_error()}else{if(jQuery(this).val()!=""){d.on_success()}}})}else{var e=jQuery(this).attr("id");jQuery(d.digito_verificador).bind("blur",function(){var f=jQuery("#"+e).val()+"-"+jQuery(this).val();if(jQuery(this).val()!=""&&!jQuery.Rut.validar(f)){d.on_error()}else{if(jQuery(this).val()!=""){d.on_success()}}})}}})}})(jQuery);jQuery.Rut={formatear:function(e,a){var c=new String(e);var b="";c=jQuery.Rut.quitarFormato(c);if(a){var d=c.charAt(c.length-1);c=c.substring(0,c.length-1)}while(c.length>3){b="."+c.substr(c.length-3)+b;c=c.substring(0,c.length-3)}b=c+b;if(b!=""&&a){b+="-"+d}else{if(a){b+=d}}return b.replace(/\./g,"")},quitarFormato:function(a){var b=new String(a);while(b.indexOf(".")!=-1){b=b.replace(".","")}while(b.indexOf("-")!=-1){b=b.replace("-","")}return b},digitoValido:function(a){if(a!="0"&&a!="1"&&a!="2"&&a!="3"&&a!="4"&&a!="5"&&a!="6"&&a!="7"&&a!="8"&&a!="9"&&a!="k"&&a!="K"){return false}return true},digitoCorrecto:function(a){largo=a.length;if(largo<2){return false}if(largo>2){rut=a.substring(0,largo-1)}else{rut=a.charAt(0)}dv=a.charAt(largo-1);jQuery.Rut.digitoValido(dv);if(rut==null||dv==null){return 0}dvr=jQuery.Rut.getDigito(rut);if(dvr!=dv.toLowerCase()){return false}return true},getDigito:function(a){var b="0";suma=0;mul=2;for(i=a.length-1;i>=0;i--){suma=suma+a.charAt(i)*mul;if(mul==7){mul=2}else{mul++}}res=suma%11;if(res==1){return"k"}else{if(res==0){return"0"}else{return 11-res}}},validar:function(a){a=jQuery.Rut.quitarFormato(a);largo=a.length;if(largo<2){return false}for(i=0;i<largo;i++){if(!jQuery.Rut.digitoValido(a.charAt(i))){return false}}var c="";for(i=(largo-1),j=0;i>=0;i--,j++){c=c+a.charAt(i)}var b="";b=b+c.charAt(0);b=b+"-";cnt=0;for(i=1,j=2;i<largo;i++,j++){if(cnt==3){b=b+".";j++;b=b+c.charAt(i);cnt=1}else{b=b+c.charAt(i);cnt++}}c="";for(i=(b.length-1),j=0;i>=0;i--,j++){c=c+b.charAt(i)}if(jQuery.Rut.digitoCorrecto(a)){return true}return false}};
