
// Main JavaScript File

// Theme Toggle Functionality
const themeToggle = document.getElementById('theme-toggle');
const body = document.body;

themeToggle.addEventListener('click', () => {
    body.classList.toggle('dark-theme');
});

// Language Switching Functionality
const languageSelect = document.getElementById('language-select');
const translateElements = document.querySelectorAll('[data-translate]');

languageSelect.addEventListener('change', async (event) => {
    const language = event.target.value;
    try {
        const response = await fetch(`/languages/${language}.json`);
        const translations = await response.json();

        translateElements.forEach(el => {
            const key = el.getAttribute('data-translate');
            if (translations[key]) {
                el.textContent = translations[key];
            }
        });
    } catch (error) {
        console.error('Error loading language file:', error);
    }
});

// API Testing Form
const apiTestForm = document.getElementById('api-test-form');
const responseOutput = document.getElementById('response-output');

apiTestForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    const endpoint = document.getElementById('endpoint').value;
    const method = document.getElementById('method').value;
    const headers = JSON.parse(document.getElementById('headers').value || '{}');
    const body = document.getElementById('body').value;

    try {
        const options = {
            method,
            headers,
        };

        if (method !== 'GET' && body) {
            options.body = body;
        }

        const response = await fetch(endpoint, options);
        const responseData = await response.json();

        responseOutput.textContent = JSON.stringify(responseData, null, 2);
    } catch (error) {
        responseOutput.textContent = `Error: ${error.message}`;
    }
});