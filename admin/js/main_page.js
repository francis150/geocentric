
const SERVER_URL = document.querySelector('._geocentric-wrapper').dataset.api_server_url

// =========================================================== //

/* Styling Tab */

// Load fonts
function loadFontsToOptions() {
    axios({
        method: 'GET',
        url: SERVER_URL + 'locations-generator/generate-fonts'
    })
    .then(res => {
        const selectElement = document.querySelector('._geocentric-wrapper .styling-tab form .general_font-family')

        res.data.forEach(font => {
            const fontOption = document.createElement('option')
            fontOption.value = font.code
            fontOption.innerHTML = font.family
            fontOption.selected = selectElement.dataset.setvalue == `${font.code} ${font.category}`
            fontOption.value = `${font.code} ${font.category}`
            fontOption.style = `@import url('https://fonts.googleapis.com/css2?family=${font.code}&display=swap'); font-family: '${font.family}', ${font.category}; color: black; font-size: 16px;`
            selectElement.appendChild(fontOption)
        })
    })
    .catch(err => {
        console.log(`ERROR FETCHING FONTS FROM SERVER: ${err.message}`)
    })
}
loadFontsToOptions()

// Reset to default styles cofirmation
document.querySelector('._geocentric-wrapper .styling-tab form .button-secondary').addEventListener('click', () => {
    confirm('Are you sure you want to restore default styles?')
})