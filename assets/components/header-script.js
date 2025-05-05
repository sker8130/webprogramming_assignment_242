// JavaScript to toggle the menu
document.getElementById('hamburger').addEventListener('click', function () {
  // Toggle the 'open' class on the nav element
  document.querySelector('nav').classList.toggle('open');
});

function confirmLogout() {
  if (confirm('Log out?')) {
    window.location.href = '/webprogramming_assignment_242/logout';
  }
}
