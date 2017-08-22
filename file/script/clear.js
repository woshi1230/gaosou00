var _sbt = false; var _frm = _frm ? _frm : 'dform';
function sbt() {_sbt = true;}
try {if(document.attachEvent) Dd(_frm).attachEvent("onsubmit", sbt); else Dd(_frm).addEventListener("submit", sbt, false);} catch(e) {}
$(window).unload(function(){
    if(!_sbt) makeRequest('action=clear', AJPath);
});