var dateFormat = function () {
    var	token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
    timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
    timezoneClip = /[^-+\dA-Z]/g,
    pad = function (val, len) {
        val = String(val);
        len = len || 2;
        while (val.length < len) val = "0" + val;
        return val;
    };

    // Regexes and supporting functions are cached through closure
    return function (date, mask, utc) {
        var dF = dateFormat;

        // You can't provide utc if you skip other args (use the "UTC:" mask prefix)
        if (arguments.length == 1 && (typeof date == "string" || date instanceof String) && !/\d/.test(date)) {
            mask = date;
            date = undefined;
        }

        // Passing date through Date applies Date.parse, if necessary
        date = date ? new Date(date) : new Date();
        if (isNaN(date)) throw new SyntaxError("invalid date");

        mask = String(dF.masks[mask] || mask || dF.masks["default"]);

        // Allow setting the utc argument via the mask
        if (mask.slice(0, 4) == "UTC:") {
            mask = mask.slice(4);
            utc = true;
        }

        var	_ = utc ? "getUTC" : "get",
        d = date[_ + "Date"](),
        D = date[_ + "Day"](),
        m = date[_ + "Month"](),
        y = date[_ + "FullYear"](),
        H = date[_ + "Hours"](),
        M = date[_ + "Minutes"](),
        s = date[_ + "Seconds"](),
        L = date[_ + "Milliseconds"](),
        o = utc ? 0 : date.getTimezoneOffset(),
        flags = {
            d:    d,
            dd:   pad(d),
            ddd:  dF.i18n.dayNames[D],
            dddd: dF.i18n.dayNames[D + 7],
            m:    m + 1,
            mm:   pad(m + 1),
            mmm:  dF.i18n.monthNames[m],
            mmmm: dF.i18n.monthNames[m + 12],
            yy:   String(y).slice(2),
            yyyy: y,
            h:    H % 12 || 12,
            hh:   pad(H % 12 || 12),
            H:    H,
            HH:   pad(H),
            M:    M,
            MM:   pad(M),
            s:    s,
            ss:   pad(s),
            l:    pad(L, 3),
            L:    pad(L > 99 ? Math.round(L / 10) : L),
            t:    H < 12 ? "a"  : "p",
            tt:   H < 12 ? "am" : "pm",
            T:    H < 12 ? "A"  : "P",
            TT:   H < 12 ? "AM" : "PM",
            Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
            o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
            S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
        };

        return mask.replace(token, function ($0) {
            return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
        });
    };
}();

// Some common format strings
dateFormat.masks = {
    "default":      "ddd mmm dd yyyy HH:MM:ss",
    shortDate:      "m/d/yy",
    mediumDate:     "mmm d, yyyy",
    longDate:       "mmmm d, yyyy",
    fullDate:       "dddd, mmmm d, yyyy",
    shortTime:      "h:MM TT",
    mediumTime:     "h:MM:ss TT",
    longTime:       "h:MM:ss TT Z",
    isoDate:        "yyyy-mm-dd",
    isoTime:        "HH:MM:ss",
    isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
    isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};

// Internationalization strings
/*
dateFormat.i18n = {
    dayNames: [
    "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
    "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
    ],
    monthNames: [
    "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
    ]
};
*/
dateFormat.i18n = {
    dayNames: [
    "Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab",
    "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
    ],
    monthNames: [
    "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nop", "Des",
    "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember"
    ]
};

// For convenience...
Date.prototype.format = function (mask, utc) {
    return dateFormat(this, mask, utc);
};

function kc(e) {
    var k;
    if (e.charCode) {
        k = e.charCode;
    } else
    if (e.keyCode) {
        k = e.keyCode;
    }
    return k;
}

function now(mask) {
    var today = new Date();
    return today.format(mask);
}

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function tab_order(e,ev){
    if (ev.keyCode==13) {
        ev.returnValue=false;if(e!=""){
            document.getElementById(e).focus();return false;
        }
    }
}

function str_input(e,ev){
    if (ev.keyCode==13) {
        ev.returnValue=false;if(e!=""){
            document.getElementById(e).focus();return false;
        }
    } else {
        if (ev.keyCode==0){
            if (ev.which==34) {
                return false;
            }
        }else if (ev.keyCode==34) {
            ev.returnValue=false;alert("Karakter ini tidak diperbolehkan!!!");
        }
    }
}

function num_input(e,ev){
    if (ev.keyCode==13) {
        ev.returnValue=false;if(e!=""){
            document.getElementById(e).focus();return false;
        }
    } else {
        if (ev.keyCode==0){
            if (ev.which<48||ev.which>57){
                return false;
            }
        }else if (ev.keyCode<48||ev.keyCode>57){
            ev.returnValue=false;
        }
    }
}

function dec_input(self_obj,e,ev){
    if (ev.keyCode==13) {
        ev.returnValue=false;if(e!=""){
            document.getElementById(e).focus();return false;
        }
    } else {
        if (ev.keyCode==0){
            if (ev.which<45||ev.which>57||ev.which==47){
                return false;
            }
            else{
                if(self_obj.value.length>0&&ev.which==45) {
                    return false;
                }else{
                    if(ev.which==46&&self_obj.value.indexOf(".")!=-1){
                        return false;
                    }else{
                        if(self_obj.value.substring(0,1)=="-"){
                            if(self_obj.value.length==16&&ev.which!=46&&self_obj.value.indexOf(".")==-1){
                                return false;
                            }
                        }else{
                            if(self_obj.value.length==15&&ev.which!=46&&self_obj.value.indexOf(".")==-1){
                                return false;
                            }
                        }
                    }
                }
            }
        }else if (ev.keyCode<45||ev.keyCode>57||ev.keyCode==47){
            ev.returnValue=false;
        }else{
            if(self_obj.value.length>0&&ev.keyCode==45) {
                ev.returnValue=false;
            }else{
                if(ev.keyCode==46&&self_obj.value.indexOf(".")!=-1){
                    ev.returnValue=false;
                }else{
                    if(self_obj.value.substring(0,1)=="-"){
                        if(self_obj.value.length==16&&ev.keyCode!=46&&self_obj.value.indexOf(".")==-1){
                            ev.returnValue=false;
                        }
                    }else{
                        if(self_obj.value.length==15&&ev.keyCode!=46&&self_obj.value.indexOf(".")==-1){
                            ev.returnValue=false;
                        }
                    }
                }
            }
        }
    }
}
function parent_dec_input(self_obj,e,ev){
    if (ev.keyCode==13) {
        ev.returnValue=false;if(e!=""){
            parent.document.getElementById(e).focus();return false;
        }
    } else {
        if (ev.keyCode==0){
            if (ev.which<45||ev.which>57||ev.which==47){
                return false;
            }
            else{
                if(self_obj.value.length>0&&ev.which==45) {
                    return false;
                }else{
                    if(ev.which==46&&self_obj.value.indexOf(".")!=-1){
                        return false;
                    }else{
                        if(self_obj.value.substring(0,1)=="-"){
                            if(self_obj.value.length==16&&ev.which!=46&&self_obj.value.indexOf(".")==-1){
                                return false;
                            }
                        }else{
                            if(self_obj.value.length==15&&ev.which!=46&&self_obj.value.indexOf(".")==-1){
                                return false;
                            }
                        }
                    }
                }
            }
        }else if (ev.keyCode<45||ev.keyCode>57||ev.keyCode==47){
            ev.returnValue=false;
        }else{
            if(self_obj.value.length>0&&ev.keyCode==45) {
                ev.returnValue=false;
            }else{
                if(ev.keyCode==46&&self_obj.value.indexOf(".")!=-1){
                    ev.returnValue=false;
                }else{
                    if(self_obj.value.substring(0,1)=="-"){
                        if(self_obj.value.length==16&&ev.keyCode!=46&&self_obj.value.indexOf(".")==-1){
                            ev.returnValue=false;
                        }
                    }else{
                        if(self_obj.value.length==15&&ev.keyCode!=46&&self_obj.value.indexOf(".")==-1){
                            ev.returnValue=false;
                        }
                    }
                }
            }
        }
    }
}
function numEditMode(e){
    //e.style.textAlign="left";
    e.value=e.value.replace(/,/g,'');
    e.select();
}

function cek_dec(e,curr){
    if (e.value==""||parseFloat(e.value)==0) {
        e.value="0.00";
    } else {
        e.value=addCommas(curr?parseFloat(e.value).toFixed(2):parseFloat(e.value));
    }
    //e.style.textAlign="right";
}

function objFocus(){
    if(document.forms[0]){
        for(var i=0;i<document.forms[0].elements.length;i++){
            if(document.forms[0].elements[i].type!="hidden"){
                if(!document.forms[0].elements[i].disabled){
                    if(!document.forms[0].elements[i].readOnly){
                        document.forms[0].elements[i].focus();
                        break;
                    }
                }
            }
        }
    }

}

function MaskedTextBox_NS_FocusMask(e, id, mask) {
	if(document.getElementById(id).value == '') {
		var i=1;
		var maskChar = mask.substr(0, 1);
		var charCode = maskChar.toLowerCase().charCodeAt(0);
		while((charCode != 57) && ((charCode < 48) || (charCode > 57)) && (charCode != 99)) {
			document.getElementById(id).value = document.getElementById(id).value + maskChar;
			maskChar = mask.substr(i, 1);
			charCode = maskChar.toLowerCase().charCodeAt(0);
			i++;
		}
	}
}

function MaskedTextBox_NS_VerifyMask(e, id, mask, autoFill) {
	var keyCode = e.which;
	var val = document.getElementById(id).value;
	var retValue = true;

	var sp_mask=0;
	for(var j=0;j<mask.length;j++){
		if(mask.charCodeAt(j) != 57) sp_mask++;
	}

	var sp_val=0;
	for(var j=0;j<val.length;j++){
		if(val.charCodeAt(j) < 48 ||val.charCodeAt(j) > 57) sp_val++;
	}
	
	if(mask.length == 0 || keyCode == 13 || keyCode == 8 || keyCode == 0) {
		retValue = true;
	} else {
	
		var maskChar = mask.substr(val.length, 1);
		var nextMaskChar = '';
		if((val.length + 1) <= mask.length)
			nextMaskChar = mask.substr(val.length + 1, 1);
	
		if ((maskChar.charCodeAt(0) == 57) && (keyCode >= 48) && (keyCode <= 57)) // digit
			retValue = true;
		else if(e.ctrlKey && keyCode == 118)
			retValue = true;

		else if((maskChar.toLowerCase().charCodeAt(0) == 99) && (((keyCode >= 65) && (keyCode <=90)) || ((keyCode >= 97) && (keyCode <= 122)))) //&& (((keyCode >= 65) && (keyCode <= 90)) || ((keyCode >= 99) && (keyCode <= 122))))
			retValue = true;

		else if(maskChar == String.fromCharCode(keyCode)) // special
			retValue = true;
		if(retValue && autoFill && sp_val<sp_mask) {
			var i=1;
			var addedKey = false;
			while(nextMaskChar != '') {
				if((val.length + i) <= mask.length)
					nextMaskChar = mask.substr(val.length + i, 1);
				if(nextMaskChar.toLowerCase() == '9' || nextMaskChar.toLowerCase() == 'c')
					nextMaskChar = '';
				var charCode = nextMaskChar.toLowerCase().charCodeAt(0);
				if((charCode != 57) && ((charCode < 48) || (charCode > 57)) && (charCode != 99)) {
					if(!addedKey) {
						document.getElementById(id).value = document.getElementById(id).value + String.fromCharCode(keyCode) + nextMaskChar;
						addedKey = true;
					} else
						document.getElementById(id).value = document.getElementById(id).value + nextMaskChar;
					retValue = false;
				}
				i++;
			}
		}
	}
	if(!retValue)
		e.preventDefault();
	return retValue;
}

function date_input(id,e,ev){
    if (ev.keyCode==13) {
        ev.returnValue=false;if(e!=""){
            document.getElementById(e).focus();return false;
        }
    } else {
        if (ev.keyCode==0){
            if (ev.which<48||ev.which>57){
                return false;
            }else{
		        return MaskedTextBox_NS_VerifyMask(ev, id, "99/99/9999", true);
            }
        }else if (ev.keyCode<48||ev.keyCode>57){
            ev.returnValue=false;
        }else{
	        return MaskedTextBox_NS_VerifyMask(ev, id, "99/99/9999", true);
        }
    }
}

function date_input1(id,e,esc,ev){
    if (ev.keyCode==13) {
        ev.returnValue=false;if(e!=""){
            if(document.getElementById(e).disabled==true)
              document.getElementById(esc).focus();
            else
              document.getElementById(e).focus();  
            return false;
        }
    } else {
        if (ev.keyCode==0){
            if (ev.which<48||ev.which>57){
                return false;
            }else{
		        return MaskedTextBox_NS_VerifyMask(ev, id, "99/99/9999", true);
            }
        }else if (ev.keyCode<48||ev.keyCode>57){
            ev.returnValue=false;
        }else{
	        return MaskedTextBox_NS_VerifyMask(ev, id, "99/99/9999", true);
        }
    }
}
max_mm=["31","29","31","30","31","30","31","31","30","31","30","31"];

function date_entry(selfObj,min_year){
	   	var tmp_val = selfObj.value;
	   	var tmp_val1="";
	   	var tmp="";
	   	var dd=""; 
	   	var mm=""; 
	   	var yy=""; 
	   	var tmp_date=""; 
		var tmp_dd=(tmp_val.indexOf("/")>=0?tmp_val.substring(0,tmp_val.indexOf("/")):tmp_val);
		if(parseInt(tmp_dd,10)<1&&tmp_dd.length==2) {
			dd="01";
		}else if(parseInt(tmp_dd,10)>31&&tmp_dd!="") {
			dd="31";
		}else if(tmp_dd.length>2) {
			if(parseInt(tmp_dd,10)<1) {
				dd="01";
			}else if(parseInt(tmp_dd,10)>31) {
				dd="31";
			}else{
				dd=tmp_dd.substring(tmp_dd.length-2);
			}
		}else{
			dd=tmp_dd;
		}
		if(tmp_val.indexOf("/")>=0) {
			tmp_date=dd+"/"; 
			tmp_val1=tmp_val.substring(tmp_val.indexOf("/")+1);
		}else {
			tmp_date=dd;
			if(dd.length==2)tmp_date+="/";
		}
		var tmp_mm=(tmp_val1.indexOf("/")>=0?tmp_val1.substring(0,tmp_val1.indexOf("/")):tmp_val1);
		if(parseInt(tmp_mm,10)<1&&tmp_mm.length==2) {
			mm="01";
		}else if(parseInt(tmp_mm,10)>12&&tmp_mm!="") {
			mm="12";
		}else if(tmp_mm.length>2) {
			if(parseInt(tmp_mm,10)<1) {
				mm="01";
			}else if(parseInt(tmp_mm,10)>12) {
				mm="12";
			}else{
				mm=tmp_mm.substring(tmp_mm.length-2);
			}
		}else{
			mm=tmp_mm;
		}
		if(parseInt(dd,10)>max_mm[parseInt(mm,10)-1]) dd=max_mm[parseInt(mm,10)-1];
		if(tmp_val1.indexOf("/")>=0) {
	     			tmp=tmp_val1.substring(tmp_val1.indexOf("/")+1);
			tmp_date=dd+"/"+mm+"/"+tmp; 
		}else if(tmp_val.indexOf("/")>=0) {
			tmp_date=dd+"/"+mm;
			if(mm.length==2)tmp_date+="/";
		}
		yy=tmp;
		if(parseInt(mm,10)==2&&parseInt(dd,10)>=29&&yy.length==4){
			if(parseInt(yy,10)%4==0){dd="29";}else{dd="28";}
		}
		if(yy!=""){
			tmp_date=dd+"/"+mm+"/"+yy; 
		}
		selfObj.value=tmp_date;
}
        
function date_entry_new(selfObj,ev,min_year){
	if((ev.keyCode==0&&ev.which>=48&&ev.which<=57)||(ev.keyCode>=48&&ev.keyCode<=57)){
	   	var tmp_val = selfObj.value;
	   	var tmp_val1="";
	   	var tmp="";
	   	var dd=""; 
	   	var mm=""; 
	   	var yy=""; 
	   	var tmp_date=""; 
		var tmp_dd=(tmp_val.indexOf("/")>=0?tmp_val.substring(0,tmp_val.indexOf("/")):tmp_val);
		if(parseInt(tmp_dd,10)<1&&tmp_dd.length==2) {
			dd="01";
		}else if(parseInt(tmp_dd,10)>31&&tmp_dd!="") {
			dd="31";
		}else if(tmp_dd.length>2) {
			if(parseInt(tmp_dd,10)<1) {
				dd="01";
			}else if(parseInt(tmp_dd,10)>31) {
				dd="31";
			}else{
				dd=tmp_dd.substring(tmp_dd.length-2);
			}
		}else{
			dd=tmp_dd;
		}
		if(tmp_val.indexOf("/")>=0) {
			tmp_date=dd+"/"; 
			tmp_val1=tmp_val.substring(tmp_val.indexOf("/")+1);
		}else {
			tmp_date=dd;
			if(dd.length==2)tmp_date+="/";
		}
		var tmp_mm=(tmp_val1.indexOf("/")>=0?tmp_val1.substring(0,tmp_val1.indexOf("/")):tmp_val1);
		if(parseInt(tmp_mm,10)<1&&tmp_mm.length==2) {
			mm="01";
		}else if(parseInt(tmp_mm,10)>12&&tmp_mm!="") {
			mm="12";
		}else if(tmp_mm.length>2) {
			if(parseInt(tmp_mm,10)<1) {
				mm="01";
			}else if(parseInt(tmp_mm,10)>12) {
				mm="12";
			}else{
				mm=tmp_mm.substring(tmp_mm.length-2);
			}
		}else{
			mm=tmp_mm;
		}
		if(parseInt(dd,10)>max_mm[parseInt(mm,10)-1]) dd=max_mm[parseInt(mm,10)-1];
		if(tmp_val1.indexOf("/")>=0) {
	     			tmp=tmp_val1.substring(tmp_val1.indexOf("/")+1);
			tmp_date=dd+"/"+mm+"/"+tmp; 
		}else if(tmp_val.indexOf("/")>=0) {
			tmp_date=dd+"/"+mm;
			if(mm.length==2)tmp_date+="/";
		}
		yy=tmp;
		if(parseInt(mm,10)==2&&parseInt(dd,10)>=29&&yy.length==4){
			if(parseInt(yy,10)%4==0){dd="29";}else{dd="28";}
		}
		if(yy!=""){
			tmp_date=dd+"/"+mm+"/"+yy; 
		}
		selfObj.value=tmp_date;
	}
}
        
function date_validation(selfObj,def_year){
	date_entry(selfObj);
	var tmp_val = selfObj.value;
  	if(selfObj.value.length!=10&&selfObj.value.length>0){
	   	var valid = true;
	   	if(tmp_val.indexOf("/")==0||parseInt(tmp_val.substring(0,tmp_val.indexOf("/")),10)==0){
	   		tmp_val="01"+tmp_val.substring(tmp_val.indexOf("/"),tmp_val.length);
	   		valid=false;
	   	}else if(tmp_val.indexOf("/")==1){
	   		tmp_val="0"+tmp_val;
	   	}else if(tmp_val.indexOf("/")>2){
	   		tmp_val=tmp_val.substring();
	   	}else if(tmp_val.indexOf("/")==-1){
			if(parseInt(tmp_val,10)<1||tmp_val=="") {
				tmp_val="01"+now("/mm/yyyy");
			}else if(tmp_val.length==1){
				tmp_val="0"+tmp_val+now("/mm/yyyy");
			}else if(parseInt(tmp_val,10)>(parseInt(now("mm"),10)==2&&parseInt(now("yyyy"),10)%4>0?28:max_mm[parseInt(now("mm"),10)-1])&&tmp_val!="") {
				tmp_val=(parseInt(now("mm"),10)==2&&parseInt(now("yyyy"),10)%4>0?28:max_mm[parseInt(now("mm"),10)-1])+now("/mm/yyyy");
			}else if(tmp_val.length>=2) {
				tmp_val=tmp_val+now("/mm/yyyy");
			}
			valid=false;
     	}
      	if(tmp_val.length!=10){
      		var tmp=tmp_val.substring(tmp_val.indexOf("/")+1,tmp_val.length);
	       	if(tmp.indexOf("/")==0||parseInt(tmp.substring(0,tmp.indexOf("/")),10)==0){
				if(tmp.substring(tmp.indexOf("/"))==now("/yyyy")){
	       			tmp_val=tmp_val.substring(0,3)+now("mm/yyyy");
				}else{
	       			tmp_val=tmp_val.substring(0,3)+"01"+tmp.substring(tmp.indexOf("/"));
				}
	       		valid=false;
	       	}else if(tmp.indexOf("/")==1){
	       		tmp_val=tmp_val.substring(0,3)+"0"+tmp;
	       	}else if(tmp.indexOf("/")==-1){
				if(tmp=="") {
					tmp=now("mm");
				}else if(parseInt(tmp,10)<1) {
					tmp="01";
				}else if(tmp.length==1){
					tmp="0"+tmp;
				}else if(parseInt(tmp,10)>12&&tmp!="") {
					tmp="12";
				}else if(tmp.length>2) {
					tmp=tmp.substring(1);
				}
				if(parseInt(tmp_val.substring(0,2),10)>(parseInt(now("yyyy"),10)%4>0&&parseInt(tmp,10)==2?28:max_mm[parseInt(tmp,10)-1])){
					tmp_val=(parseInt(now("yyyy"),10)%4>0&&parseInt(tmp,10)==2?28:max_mm[parseInt(tmp,10)-1])+"/"+tmp+now("/yyyy");
				}else{
					tmp_val=tmp_val.substring(0,3)+tmp+now("/yyyy");
				}
	       		valid=false;
	       	}
	       	if(tmp_val.length!=10){
	       		valid=false;
	       		if(def_year==null){
	       			tmp_val=tmp_val.substring(0,6)+now("yyyy");
	       		}else{
	       			tmp_val=tmp_val.substring(0,6)+def_year;
	       		}
				if(parseInt(tmp_val.substring(0,2),10)>(parseInt(tmp_val.substring(6),10)%4>0&&parseInt(tmp_val.substring(3,5),10)==2?28:max_mm[parseInt(tmp_val.substring(3,5),10)-1])) {
					tmp_val=(parseInt(tmp_val.substring(6),10)%4>0&&parseInt(tmp_val.substring(3,5),10)==2?28:max_mm[parseInt(tmp_val.substring(3,5),10)-1])+tmp_val.substring(2);
				}
	       	}
      	}
      	if(!valid) alert("Isi tanggal yang benar");
      	selfObj.value=tmp_val;
   	}else if(selfObj.value.length==10){
		if(tmp_val.indexOf("/")==0||tmp_val.indexOf("/")==1
		||tmp_val.substring(3).indexOf("/")==0||tmp_val.substring(3).indexOf("/")==1){
			if(!valid) alert("Isi tanggal yang benar");
			selfObj.value=now("dd/mm/yyyy");
		}
	}
}


function trimString(sInString) {
    sInString = (sInString==null?"":sInString.replace( /^\s+/g, "" )); // strip leading
    return sInString.replace( /\s+$/g, "" ); // strip trailing
}

function setLayout(){
	if(document.getElementById("hd_tabbar")){
		hdtabbar.setSize(parent.parentLayout.cells("c").getWidth()-8,parent.parentLayout.cells("c").getHeight()-60);
		if(document.getElementById("hdtabbar_detail")&&hdtabbar_detail.toString()!="[object HTMLDivElement]")
			hdtabbar_detail.setSize(parent.parentLayout.cells("c").getWidth()-20,parent.parentLayout.cells("c").getHeight()-(document.getElementById("hdtabbar_detail").offsetTop+90));
	}
}

function cek_curr(e){
    if (e.value=="") {
            e.value="0.00";
    } else {
            e.value=roundToDigit(e.value,2);
    }
    e.dir="rtl";
}

function roundToDigit(stri,dgt) {
    var str = "";
    str = new String(stri);
    var dbl = parseFloat(str.replace(/,/g,""));
    var num = new Number(dbl);

    str = str.substring(num.toFixed(dgt).toString().length);
    if(str.length > 0 && parseInt(str.charAt(0)) >= 5 ) num += 0.001;
    str = num.toFixed(dgt).toString();
    var ret = '.00';
    if(str.indexOf('.')>0) {
        ret = str.substring(str.lastIndexOf('.'));
        str = str.substring(0, str.lastIndexOf('.'));
    }
    for(var c = str.length; c > 3;) {
        if(c > 3) ret = ','+str.substring(c-3)+ret;
        str = str.substring(0, c-3);
        c = str.length;
    }
    ret = str+ret;
    return ret;
}

