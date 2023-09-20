function toggleMenu() {
  const menu = document.getElementsByClassName('menu');
  for (let i = 0; i < menu.length; i++) {
    if (menu[i].className === 'menu close') {
      menu[i].className = 'menu open';
    } else if (menu[i].className === 'menu open') {
      menu[i].className = 'menu close';
    }
  }
  const feat = document.getElementById('featurer');
  if (feat && feat.className === 'seen') toggleFeatures();
}

function toggleFeatures() {
  const feat = document.getElementById('featurer');
  if (feat.className === 'unseen') {
    feat.className = 'seen';
  } else if (feat.className === 'seen') {
    feat.className = 'unseen';
  }
}

document.getElementById('hamburger-lines').addEventListener('click', toggleMenu);
document.getElementById('features').addEventListener('click', toggleFeatures);
document.getElementById('featurer').addEventListener('click', toggleMenu);
