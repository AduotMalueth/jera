document.getElementById('commentForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const userName = document.getElementById('userName').value.trim();
    const commentText = document.getElementById('commentInput').value.trim();
    const profilePictureFile = document.getElementById('profilePicture').files[0];

    if (!userName || !commentText || !profilePictureFile) {
        alert('Please fill out all fields and upload a profile picture.');
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        const profilePictureUrl = e.target.result;
        const commentsList = document.getElementById('commentsList');

        const commentItem = createCommentItem(userName, commentText, profilePictureUrl);
        commentsList.appendChild(commentItem);

        // Clear the form
        document.getElementById('commentForm').reset();
    };

    reader.readAsDataURL(profilePictureFile);
});

function createCommentItem(userName, commentText, profilePictureUrl) {
    const commentItem = document.createElement('div');
    commentItem.className = 'comment-item';

    // Add profile picture
    const profileImg = document.createElement('img');
    profileImg.src = profilePictureUrl;
    commentItem.appendChild(profileImg);

    // Add comment content
    const commentContent = document.createElement('div');
    commentContent.className = 'comment-content';

    const commentName = document.createElement('div');
    commentName.className = 'comment-name';
    commentName.textContent = userName;
    commentContent.appendChild(commentName);

    const commentTextDiv = document.createElement('div');
    commentTextDiv.className = 'comment-text';
    commentTextDiv.textContent = commentText;
    commentContent.appendChild(commentTextDiv);

    commentItem.appendChild(commentContent);

    // Add actions (Edit and Delete buttons)
    const actionsDiv = document.createElement('div');
    actionsDiv.className = 'comment-actions';

    const editButton = document.createElement('button');
    editButton.textContent = 'Edit';
    editButton.addEventListener('click', () => editComment(commentItem, commentTextDiv));
    actionsDiv.appendChild(editButton);

    const deleteButton = document.createElement('button');
    deleteButton.textContent = 'Delete';
    deleteButton.addEventListener('click', () => commentItem.remove());
    actionsDiv.appendChild(deleteButton);

    commentItem.appendChild(actionsDiv);

    return commentItem;
}

function editComment(commentItem, commentTextDiv) {
    // Check if already in edit mode
    if (commentItem.classList.contains('edit-mode')) return;

    commentItem.classList.add('edit-mode');

    // Replace text with a textarea
    const textarea = document.createElement('textarea');
    textarea.value = commentTextDiv.textContent;
    commentTextDiv.replaceWith(textarea);

    // Add Save and Cancel buttons
    const actionsDiv = commentItem.querySelector('.comment-actions');

    const saveButton = document.createElement('button');
    saveButton.textContent = 'Save';
    saveButton.addEventListener('click', () => {
        const newText = textarea.value.trim();
        if (newText) {
            commentTextDiv.textContent = newText;
            textarea.replaceWith(commentTextDiv);
            commentItem.classList.remove('edit-mode');
            saveButton.remove();
            cancelButton.remove();
        }
    });

    const cancelButton = document.createElement('button');
    cancelButton.textContent = 'Cancel';
    cancelButton.addEventListener('click', () => {
        textarea.replaceWith(commentTextDiv);
        commentItem.classList.remove('edit-mode');
        saveButton.remove();
        cancelButton.remove();
    });

    actionsDiv.appendChild(saveButton);
    actionsDiv.appendChild(cancelButton);
}
