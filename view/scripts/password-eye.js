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
  const input = document.getElementById('new_user_password');
  const type = input.getAttribute('type');
  if (type === 'password') {
    input.setAttribute('type', 'text');
  } else if (type === 'text') {
    input.setAttribute('type', 'password');
  }
}

function toggleEye3() {
  const input = document.getElementById('new_user_password_confirm');
  const type = input.getAttribute('type');
  if (type === 'password') {
    input.setAttribute('type', 'text');
  } else if (type === 'text') {
    input.setAttribute('type', 'password');
  }
}

function toggleEye4() {
  const input = document.getElementById('lock');
  const type = input.getAttribute('type');
  if (type === 'password') {
    input.setAttribute('type', 'text');
  } else if (type === 'text') {
    input.setAttribute('type', 'password');
  }
}

const eye1 = document.getElementById('eye-1');
const eye2 = document.getElementById('eye-2');
const eye3 = document.getElementById('eye-3');
const eye4 = document.getElementById('eye-4');

if (eye1) eye1.addEventListener('click', toggleEye1);
if (eye2) eye2.addEventListener('click', toggleEye2);
if (eye3) eye3.addEventListener('click', toggleEye3);
if (eye4) eye4.addEventListener('click', toggleEye4);
