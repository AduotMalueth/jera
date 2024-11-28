function openpostCommentModal() {
    // Open modal logic here
    // When user submits the form, prevent default form submission:
    const form = document.getElementById('commentForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();  // Prevent default form submission
        
        const formData = new FormData(form);
        
        fetch('post_comment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Comment posted successfully!');
                // Optionally, you can refresh the comments or close the modal here
            } else {
                alert('Error posting comment: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
}
