let enableSaltCheckbox, passwordSaltFormSection;

document.addEventListener("click", copyTextFromInput);
document.addEventListener("click", removeContainer);
document.addEventListener('click', toggleInputPassowordCharsVisibility);
document.addEventListener('DOMContentLoaded', function () {
  enableSaltCheckbox = document.getElementById('enable-salt-checkbox');
  passwordSaltFormSection = document.getElementById('password-salt');

  enableSaltCheckbox.addEventListener('change', togglePasswordSaltFieldsetVisibility);

  togglePasswordSaltFieldsetVisibility();
});

function togglePasswordSaltFieldsetVisibility() {
  passwordSaltFormSection.classList.toggle('hidden', !enableSaltCheckbox.checked);
  passwordSaltFormSection.disabled = !enableSaltCheckbox.checked;
}

function copyTextFromInput(ev) {
  let button = ev.target.closest('button.copy-btn');
  if (button) {
    var textContainer = button.previousElementSibling;

    if (navigator.clipboard) {
      navigator.clipboard.writeText(textContainer.value);
    } else {
      textContainer.select();

      document.execCommand("copy");
    }
  }
}

function removeContainer(ev) {
  let button = ev.target.closest('button.close-btn');
  if (button) {
    let elementToRemove = button.parentElement.parentElement;
    elementToRemove.remove();
  }
}

function toggleInputPassowordCharsVisibility(ev) {
  let button = ev.target.closest('button.toggle-password-visibility');
  if (button) {
    let input = button.previousElementSibling;
    if (input.type !== 'password') {
      input.type = 'password';
    } else {
      input.type = 'text';
    }
  }
}
