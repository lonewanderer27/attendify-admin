let menu = document.querySelectorAll('.menu')
let sidebar = document.querySelector('.sidebar')
let mainContent = document.querySelector('.main--content')

menu.forEach(menu => {
    menu.addEventListener('click', () => {
        sidebar.classList.toggle('active')
        mainContent.classList.toggle('active')
    })
})


// assign onclick listeners on all card element class
let cardTitle = document.querySelectorAll('.card--title')
cardTitle.forEach(card => {
    card.addEventListener('click', () => {
        // navigate to the event page
        window.location.href = '/event'
        
        // make the cursor a pointer when hovering on the card
        card.style.cursor = 'pointer'
    })
})


// JavaScript functions for modal functionality
function openModal() {
    document.getElementById('eventModal').style.display = 'block';
  }
  
  function closeModal() {
    document.getElementById('eventModal').style.display = 'none';
  }
  
  // Optional: Handle form submission
  document.getElementById('eventForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission for now, you can handle it as needed
    // Add logic here to process form data (e.g., send to server)
    closeModal(); // Close modal after form submission
  });
  
  // Function to handle email input and tag creation
  function handleEmailInput(event) {
      const emailInput = document.getElementById('email-input');
      const tagsContainer = document.getElementById('tags-container');
    
      if (event.key === 'Enter') {
        const email = emailInput.value.trim();
        if (email) {
          const tag = createTag(email);
          tagsContainer.appendChild(tag);
          emailInput.value = '';
        }
        event.preventDefault();
      }
    
      if (event.key === 'Backspace' && emailInput.value === '') {
        const tags = tagsContainer.querySelectorAll('.tag');
        if (tags.length > 0) {
          tags[tags.length - 1].remove();
        }
      }
    }
    
    // Function to create a tag element
    function createTag(email) {
      const tag = document.createElement('div');
      tag.classList.add('tag');
      
      const emailSpan = document.createElement('span');
      emailSpan.classList.add('email');
      emailSpan.textContent = email;
      
      const removeBtn = document.createElement('span');
      removeBtn.classList.add('remove');
      removeBtn.textContent = 'x';
      removeBtn.addEventListener('click', () => tag.remove());
    
      tag.appendChild(emailSpan);
      tag.appendChild(removeBtn);
      
      return tag;
    }
    