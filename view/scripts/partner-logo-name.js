function updateName() {
  const input = document.getElementById('partner_logo');
  const target = document.getElementById('name_partner_logo');
  target.innerHTML = input.files[0].name;
}

document.getElementById('partner_logo').addEventListener('change', updateName);
