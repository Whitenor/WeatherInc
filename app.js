let shortcodeOutput = document.querySelector('#shortcodeCityOutput');
document.querySelector('#copy').addEventListener('click', function(e){
    e.preventDefault();
    navigator.clipboard.writeText(shortcodeOutput.value);
})