function openSidebar() {
    document.getElementById(`sidebar`).classList.remove(`translate-x-full`);
    document.getElementById(`sidebar`).classList.add(`translate-x-0`);
    document.getElementById(`mainContent`).classList.add(`mr-64`);
    document.getElementById(`openSidebarBtn`).classList.add(`hidden`);
  }
  function closeSidebar() {
    document.getElementById(`sidebar`).classList.remove(`translate-x-0`);
    document.getElementById(`sidebar`).classList.add(`translate-x-full`);
    document.getElementById(`mainContent`).classList.remove(`mr-64`);
    document.getElementById(`openSidebarBtn`).classList.add(`hidden`);
  }

  