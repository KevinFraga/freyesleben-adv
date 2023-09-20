function updateName() {
  const input = document.getElementById('avatar');
  const target = document.getElementById('file-name-avatar');
  target.innerHTML = input.files[0].name;
}

document.getElementById('avatar').addEventListener('change', updateName);
