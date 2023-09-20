function handleCPF(input) {
  let value = input.value;

  if (value.length > 3 && value.length <= 6) {
    value = value.replace(/[^\d]/g, '');
    value = `${value.substring(0, 3)}.${value.substring(3)}`;
  }

  if (value.length > 7 && value.length <= 9) {
    value = value.replace(/[^\d]/g, '');
    value = `${value.substring(0, 3)}.${value.substring(3, 6)}.${value.substring(6)}`;
  }

  if (value.length > 11) {
    value = value.replace(/[^\d]/g, '');
    value = `${value.substring(0, 3)}.${value.substring(3, 6)}.${value.substring(6, 9)}-${value.substring(9)}`;
  }

  input.value = value;
}

function handlePhone(input) {
  let value = input.value;

  value = value.replace(/[^\d]/g, '');

  if (value.length > 2) {
    value = `(${value.substring(0, 2)}) ${value.substring(2)}`;
  }
  if (value.length > 10) {
    value = `${value.substring(0, 10)}-${value.substring(10)}`;
  }

  input.value = value;
}
