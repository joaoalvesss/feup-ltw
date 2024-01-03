const searchUsernameInput = document.querySelector('#searchUsername');
if (searchUsernameInput) {
  searchUsernameInput.addEventListener('input', async function() {
    const searchValue = this.value;
    if (searchValue.trim() === '') {
      const searchResults = document.querySelector('#searchResults');
      searchResults.innerHTML = '';
      return;
    }

    const response = await fetch('../utils/api_users.php?search=' + encodeURIComponent(searchValue));
    const users = await response.json();

    const searchResults = document.querySelector('#searchResults');
    searchResults.innerHTML = '';
    
    for (const user of users) {
      const listItem = document.createElement('li');
      listItem.textContent = user.username + ' - ' + user.name;

      listItem.addEventListener('click', function() {
        const selectedUser = {
          username: user.username,
          name: user.name,
          is_admin: user.is_admin,
          is_agent: user.is_agent,
          departmentId: user.department_id 
        };
      
        populateForm(selectedUser);
      });
      searchResults.appendChild(listItem);
    }
  });
}

function populateForm(user) {
  const usernameInput = document.querySelector('#usernameInput');
  const nameInput = document.querySelector('#nameInput');
  const roleInput = document.querySelector('#rankInput');
  const departmentIdInput = document.querySelector('#departmentIdInput');

  usernameInput.value = user.username;
  nameInput.value = user.name;
  departmentIdInput.value = user.departmentId;
  if (user.is_admin === 1) {
    roleInput.value = "admin";
  }
  else if (user.is_agent === 1) {
    roleInput.value = "agent";
  }
  else {
    roleInput.value = "user";
  }
  const event = new Event('change');
  roleInput.dispatchEvent(event);

  userDetailsForm.style.display = 'block';
  userDetails.style.display = 'flex';
}




