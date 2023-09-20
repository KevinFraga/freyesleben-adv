function toggleInfo() {
  const menu = document.getElementsByClassName('more-info');
  for (let i = 0; i < menu.length; i++) {
    if (menu[i].className === 'more-info off') {
      menu[i].className = 'more-info on';
      document.getElementById('more-info-bubble').addEventListener('click', toggleInfo);
    } else if (menu[i].className === 'more-info on') {
      menu[i].className = 'more-info off';
    }
  }
}

document.getElementById('more-info').addEventListener('click', toggleInfo);
