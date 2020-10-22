const UserComment = () => {

	const focusCommentBtn = document.querySelector('.focus-comment-btn');
	const commentAuthorField = document.getElementById('comment-author');

	// console.log(focusCommentBtn, commentAuthorField);

	if(focusCommentBtn !== null && commentAuthorField !== null ) {
		focusCommentBtn.addEventListener('click', function(e) {
			commentAuthorField.focus();
		})

	}
}


export default UserComment;