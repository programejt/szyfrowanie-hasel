document.addEventListener("click", function (ev) {
  var target = ev.target;
  if (target.classList.contains("copy-btn")) {
    var textContainer = target.parentElement.previousElementSibling.children[0];

    /*if(document.selection){
      var range = document.body.createTextRange();
      range.moveToElementText(textContainer);
      range.select();
    }else */
    // if (window.getSelection) {
    //   var range = document.createRange();
    //   range.selectNodeContents(textContainer);
    //   window.getSelection().removeAllRanges();
    //   window.getSelection().addRange(range);
    // }

    textContainer.select();

    document.execCommand("copy");
  } else if (target.classList.contains('close-btn')) {
    let elementToRemove = target.parentElement.parentElement;
    elementToRemove.remove();
  }
}, true);