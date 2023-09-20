function loginChange(value) {
  const email = document.getElementById('login-email');
  const cpf = document.getElementById('login-cpf');

  if (value == 'cpf') {
    email.style.display = 'none';
    cpf.style.display = 'block';
  }
  if (value == 'email') {
    email.style.display = 'block';
    cpf.style.display = 'none';
  }
}

const radioInputs = document.getElementsByName('kind');

for (const input of radioInputs) {
  input.addEventListener('change', function () {
    loginChange(this.value);
  });
}
