function toggleEye1() {
  const input = document.getElementById('password');
  const type = input.getAttribute('type');
  if (type === 'password') {
    input.setAttribute('type', 'text');
  } else if (type === 'text') {
    input.setAttribute('type', 'password');
  }
}

function toggleEye2() {
  const input = document.getElementById('confirm_password');
  const type = input.getAttribute('type');
  if (type === 'password') {
    input.setAttribute('type', 'text');
  } else if (type === 'text') {
    input.setAttribute('type', 'password');
  }
}

document.getElementById('eye-1').addEventListener('click', toggleEye1);
document.getElementById('eye-2').addEventListener('click', toggleEye2);