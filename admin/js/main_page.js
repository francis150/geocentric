// =========================================================== //

/* Styling Tab */

// Load fonts
function loadFontsToOptions() {
    axios({
        method: 'GET',
        url: 'https://geocentric-plugin-server.herokuapp.com/locations-generator/generate-fonts'
    })
    .then(res => {
        console.log(res.data)
    })
    .catch(err => {
        console.log(`ERROR FETCHING FONTS FROM SERVER: ${err.message}`)
    })
}
loadFontsToOptions()