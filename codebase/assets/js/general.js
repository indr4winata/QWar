/**
 * Number.prototype.format(n, x, s, c)
 * 
 * @param integer n: length of decimal
 * @param integer x: length of whole part
 * @param mixed   s: sections delimiter
 * @param mixed   c: decimal delimiter
 */
function numberformat(number, n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = Number(number).toFixed(Math.max(0, n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
function isDate(value, sepVal, dayIdx, monthIdx, yearIdx) {
	try {
		//Change the below values to determine which format of date you wish to check. It is set to dd/mm/yyyy by default.
		var DayIndex = dayIdx !== undefined ? dayIdx : 0; 
		var MonthIndex = monthIdx !== undefined ? monthIdx : 0;
		var YearIndex = yearIdx !== undefined ? yearIdx : 0;
 
		var SplitValue = value.split(sepVal);
		var OK = true;
		if (!(SplitValue[DayIndex].length == 1 || SplitValue[DayIndex].length == 2)) {
			OK = false;
		}
		if (OK && !(SplitValue[MonthIndex].length == 1 || SplitValue[MonthIndex].length == 2)) {
			OK = false;
		}
		if (OK && SplitValue[YearIndex].length != 4) {
			OK = false;
		}
		if (OK) {
			var Day = parseInt(SplitValue[DayIndex], 10);
			var Month = parseInt(SplitValue[MonthIndex], 10);
			var Year = parseInt(SplitValue[YearIndex], 10);
 
			if (OK = (Year > 1900) ) {
				if (OK = (Month <= 12 && Month > 0)) {

					var LeapYear = (((Year % 4) == 0) && ((Year % 100) != 0) || ((Year % 400) == 0));   
					
					if(OK = Day > 0)
					{
						if (Month == 2) {  
							OK = LeapYear ? Day <= 29 : Day <= 28;
						} 
						else {
							if ((Month == 4) || (Month == 6) || (Month == 9) || (Month == 11)) {
								OK = Day <= 30;
							}
							else {
								OK = Day <= 31;
							}
						}
					}
				}
			}
		}
		return OK;
	}
	catch (e) {
		return false;
	}
} 
function onlyNumbers(evt){
	var charCode = (evt.which) ? evt.which : evt.keyCode
	
	//check if it has comma or dot period. these symbol can only inputted once...
	var val = this.value;
	if(val.indexOf(".") == -1 ){ //still no dot
		if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && (charCode < 37 || charCode > 40) ){ //allow dot for dec separator
			return false;
		}
	}else{ //have dot, validate only 2 numbers after dot
		if (!evt.ctrlKey && !evt.metaKey && !evt.altKey) {
			if (charCode > 40 && (charCode < 48 || charCode > 57) && (charCode < 37 || charCode > 40) ){ //do not allow dot or comma
				return false;
			}else if(charCode > 40 && val.indexOf(".") + 3 == val.length){
				return false;
			}
		}
	}
	return true;
}
$(function(){
	$(".onlyHexa").keypress(function(evt){
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		
		//check if it has comma or dot period. these symbol can only inputted once...
		var val = $(this).val();
		if ( charCode > 31 && (charCode < 65 || charCode > 70) && (charCode < 97 || charCode > 102) && (charCode < 48 || charCode > 57) && charCode != 46 && (charCode < 37 || charCode > 40) ){ //allow dot for dec separator
			return false;
		}
        return true;
	});
	$(".onlyNumbers").keypress(onlyNumbers);
	
	
	$("select.form-select").select2();
});