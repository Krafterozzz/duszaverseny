document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('application-form');
    const messageDiv = document.getElementById('message');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const response = await fetch('submit_application.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                messageDiv.textContent = result.message;
                messageDiv.style.color = 'green';
                form.reset();
            } else {
                messageDiv.textContent = result.message;
                messageDiv.style.color = 'red';
            }
        } catch (error) {
            console.error('Hiba történt:', error);
            messageDiv.textContent = 'Hiba történt a jelentkezés során.';
            messageDiv.style.color = 'red';
        }
    });
});