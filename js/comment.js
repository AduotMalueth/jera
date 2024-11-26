// Select elements
const commentForm = document.getElementById('commentForm');
const commentInput = document.getElementById('commentInput');
const commentsList = document.getElementById('commentsList');

// Handle form submission
commentForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form from refreshing the page

    const commentText = commentInput.value.trim();

    if (commentText) {
        addComment(commentText);
        commentInput.value = ''; // Clear the textarea
    }
});

// Add a comment to the list
function addComment(text) {
    const commentDiv = document.createElement('div');
    commentDiv.className = 'comment';

    const commentText = document.createElement('span');
    commentText.textContent = text;

    const dropdown = createDropdown(commentDiv, commentText);

    commentDiv.appendChild(commentText);
    commentDiv.appendChild(dropdown);

    commentsList.appendChild(commentDiv);
}

// Create dropdown for actions
function createDropdown(commentDiv, commentText) {
    const dropdown = document.createElement('div');
    dropdown.className = 'dropdown';

    const dropdownButton = document.createElement('button');
    dropdownButton.className = 'dropdown-button';
    dropdownButton.textContent = 'Actions';

    const dropdownMenu = document.createElement('div');
    dropdownMenu.className = 'dropdown-menu';

    // Add action buttons
    const viewButton = createActionButton('View', () => {
        alert(`Comment: ${commentText.textContent}`);
    });

    const editButton = createActionButton('Edit', () => {
        const newComment = prompt('Edit your comment:', commentText.textContent);
        if (newComment) commentText.textContent = newComment.trim();
    });

    const deleteButton = createActionButton('Delete', () => {
        if (confirm('Are you sure you want to delete this comment?')) {
            commentDiv.remove();
        }
    });

    const updateButton = createActionButton('Update', () => {
        const updatedComment = prompt('Update your comment:', commentText.textContent);
        if (updatedComment) commentText.textContent = updatedComment.trim();
    });

    dropdownMenu.append(viewButton, editButton, deleteButton, updateButton);

    // Toggle dropdown menu visibility
    dropdownButton.addEventListener('click', () => {
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    dropdown.appendChild(dropdownButton);
    dropdown.appendChild(dropdownMenu);

    return dropdown;
}

// Helper function to create an action button
function createActionButton(label, onClick) {
    const button = document.createElement('button');
    button.textContent = label;
    button.className = 'action-button';
    button.addEventListener('click', onClick);
    return button;
}
