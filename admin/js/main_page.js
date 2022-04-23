
const MAIN_WRAPPER_DATA = document.querySelector('._geocentric-wrapper').dataset

const SERVER_URL = MAIN_WRAPPER_DATA.api_server_url
const GEODATABASE_URL = MAIN_WRAPPER_DATA.geodatabase_url
const APPSERO_API_KEY = MAIN_WRAPPER_DATA.appsero_api_key
const APPSERO_PLUGIN_NAME = MAIN_WRAPPER_DATA.appsero_plugin_name
const PRIMARY_KEYWORD = MAIN_WRAPPER_DATA.primary_keyword
const URL_PARAMS = new URLSearchParams(window.location.search)
const USER_INPUT_DATA = JSON.parse(MAIN_WRAPPER_DATA.user_input_data)

window.addEventListener('load', () => {
    document.querySelector('._geocentric-wrapper').style.display = 'inherit'
})

// =========================================================== //

/** Styling Tab **/
if (URL_PARAMS.get('tab') == 'styling') {
    
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
    document.querySelector('._geocentric-wrapper .styling-tab form .button-secondary').addEventListener('click', (e) => {
        if (!confirm('Are you sure you want to restore default styles?')) {
            e.preventDefault()
        }
    })
}

/** New Location Form Tab **/
if (URL_PARAMS.get('tab') == 'new-location-form') {

    const selectCountryElement = document.querySelector('._geocentric-wrapper .new-location-form .newlocationform_country')
    const selectStateElement = document.querySelector('._geocentric-wrapper .new-location-form .newlocationform_state')
    const selectCityElement = document.querySelector('._geocentric-wrapper .new-location-form .newlocationform_city')
    const neighborhoodsTextArea = document.querySelector('._geocentric-wrapper .new-location-form .newlocationform_neigborhoods')
    const newLocationForm = document.querySelector('._geocentric-wrapper .new-location-form form')

    // Load countries to countries dropdown
    function loadCountriesToDropdown () {
        selectCountryElement.innerHTML = `<option value="" selected disabled>Loading...</option>`
        selectStateElement.innerHTML = `<option value="" selected disabled>---</option>`
        selectCityElement.innerHTML = `<option value="" selected disabled>---</option>`

        axios({
            method: 'GET',
            url: GEODATABASE_URL + 'countries',
            headers: {'access_key': '%^%^$#'}
        })
        .then(res => {
            selectCountryElement.innerHTML = `<option value="" selected disasbled>Choose a country...</option>`

            res.data.forEach(country => {
                const countryOption = document.createElement('option')
                countryOption.value = country.iso2
                countryOption.innerHTML = country.name
                selectCountryElement.appendChild(countryOption)
            })
        })
        .catch(err => {
            console.log(`ERROR FETCHING COUNTRIES: ${err.message}`)
        })
    }
    loadCountriesToDropdown()

    // Load states dropdown when country is selected
    selectCountryElement.addEventListener('change', (e) => {
        selectStateElement.innerHTML = `<option value="" selected disabled>Loading...</option>`
        selectCityElement.innerHTML = `<option value="" selected disabled>---</option>`
        neighborhoodsTextArea.innerHTML = ''
        neighborhoodsTextArea.placeholder = ''
        neighborhoodsTextArea.disabled = true

        selectCountryElement.dataset.countryName = selectCountryElement.options[selectCountryElement.selectedIndex].text

        axios({
            method: 'GET',
            url: `${GEODATABASE_URL}countries/${e.target.value}/states`,
            headers: {'access_key': '%^%^$#'}
        })
        .then(res => {

            if (!Array.isArray(res.data)) return selectStateElement.innerHTML = `<option value="" selected disabled>No data available...</option>`

            selectStateElement.innerHTML = `<option value="" selected disabled>Choose a state...</option>`

            res.data.forEach(state => {
                const stateOption = document.createElement('option')
                stateOption.value = state.code
                stateOption.innerHTML = state.name
                selectStateElement.appendChild(stateOption)
            })
        })
        .catch(err => {
            console.log(`ERROR FETCHING STATES: ${err.message}`)
        })
    })

    // Load cities dropdown when state is selected
    selectStateElement.addEventListener('change', (e) => {
        selectCityElement.innerHTML = `<option value="" selected disabled>Loading...</option>`
        neighborhoodsTextArea.innerHTML = ''
        neighborhoodsTextArea.placeholder = ''
        neighborhoodsTextArea.disabled = true

        selectStateElement.dataset.stateName = selectStateElement.options[selectStateElement.selectedIndex].text

        axios({
            method: 'GET',
            url: `${GEODATABASE_URL}countries/${selectCountryElement.value}/states/${e.target.value}/cities`,
            headers: {'access_key': '%^%^$#'}
        })
        .then(res => {
            
            if (!Array.isArray(res.data)) return selectCityElement.innerHTML = `<option value="" selected disabled>No data available...</option>`

            selectCityElement.innerHTML = `<option value="" selected disabled>Choose a city...</option>`

            res.data.forEach(city => {
                const cityOption = document.createElement('option')
                cityOption.value = city.id
                cityOption.innerHTML = city.name
                selectCityElement.appendChild(cityOption)
            })
        })
        .catch(err => {
            console.log(`ERROR FETCHING CITIES: ${err.message}`)
        })
    })

    // Load neigborhoods to textarea when city is selected
    selectCityElement.addEventListener('change', (e) => {
        neighborhoodsTextArea.innerHTML = ''
        neighborhoodsTextArea.placeholder = 'Loading...'

        selectCityElement.dataset.cityName = selectCityElement.options[selectCityElement.selectedIndex].text

        axios({
            method: 'GET',
            url: `${GEODATABASE_URL}countries/${selectCountryElement.value}/states/${selectStateElement.value}/cities/${e.target.value}`,
            headers: {'access_key': '%^%^$#'}
        })
        .then(res => {
            neighborhoodsTextArea.disabled = false
            neighborhoodsTextArea.placeholder = ''
            if (res.data.neighborhoods) neighborhoodsTextArea.innerHTML = res.data.neighborhoods.toString()
            else neighborhoodsTextArea.placeholder = 'No data available...'
        })
        .catch(err => {
            console.log(`ERROR FETCHING NEIGBORHOODS: ${err.message}`)
        })
    })

    // toggle between GBP Place ID and StreetZIP
    document.querySelector('._geocentric-wrapper .new-location-form .newlocationform_use-streetzip').addEventListener('click', (e) =>{
        document.querySelector('._geocentric-wrapper .new-location-form .gbp-input-group').style.display = e.target.checked ? 'none' : 'flex'
        document.querySelector('._geocentric-wrapper .new-location-form .streetzip-input-group').style.display = e.target.checked ? 'flex' : 'none'
        document.querySelector('._geocentric-wrapper .new-location-form .streetzip-input-group .newlocationform_street').required = e.target.checked
        document.querySelector('._geocentric-wrapper .new-location-form .streetzip-input-group .newlocationform_zipcode').required = e.target.checked
    })

    // New Location form create button
    document.querySelector('._geocentric-wrapper .new-location-form .form-footer .create-button').addEventListener('click', (e) => {
        if (!newLocationForm.newlocationform_country.value || 
            !newLocationForm.newlocationform_state.value || 
            !newLocationForm.newlocationform_city.value ||
            (newLocationForm.newlocationform_useStreetzip.checked && 
            (!newLocationForm.newlocationform_street.value ||
            !newLocationForm.newlocationform_zipcode.value)))
        return alert('Please fill up all required fields (*)')

        disasbleNewLocationForm()
        e.target.innerHTML = 'Importing data...'
        document.querySelector('._geocentric-wrapper .new-location-form .form-footer img').style.display = 'inherit'

        const uuid = uuidv4()

        const newLocation = {
            id: uuid,
            city: {
                id: newLocationForm.newlocationform_city.value,
                name: newLocationForm.newlocationform_city.dataset.cityName
            },
            state: {
                code: newLocationForm.newlocationform_state.value,
                name: newLocationForm.newlocationform_state.dataset.stateName
            },
            country: {
                iso2: newLocationForm.newlocationform_country.value,
                name: newLocationForm.newlocationform_country.dataset.countryName
            }
        }

        const mainLocation = getPrimaryLocation() ? getPrimaryLocation() : newLocation

        const payload = {
            requesting_domain: window.location.origin,
            id: uuidv4(),
            city: {
                id: newLocationForm.newlocationform_city.value,
                name: newLocationForm.newlocationform_city.dataset.cityName
            },
            state: {
                code: newLocationForm.newlocationform_state.value,
                name: newLocationForm.newlocationform_state.dataset.stateName
            },
            country: {
                iso2: newLocationForm.newlocationform_country.value,
                name: newLocationForm.newlocationform_country.dataset.countryName
            },
            appsero_info: {
                appsero_api_key: APPSERO_API_KEY,
                appsero_plugin_name: APPSERO_PLUGIN_NAME
            },
            primary_keyword: PRIMARY_KEYWORD,
            mainLocation: {
                country_iso2: mainLocation.country.iso2,
                state_code: mainLocation.state.code,
                city: mainLocation.city
            }
        }

        if (newLocationForm.newlocationform_useStreetzip.checked) {
            newLocation.street = newLocationForm.newlocationform_street.value
            newLocation.zip_code = newLocationForm.newlocationform_zipcode.value
            payload.mainLocation.street = newLocationForm.newlocationform_street.value
            payload.mainLocation.zip_code = newLocationForm.newlocationform_zipcode.value
        } else {
            newLocation.google_place_id = newLocationForm.newlocationform_gbp_placeid.value
            payload.mainLocation.place_id = newLocationForm.newlocationform_gbp_placeid.value
        }

        if (newLocationForm.newlocationform_neigborhoods.value)
        newLocation.neighbourhoods = newLocationForm.newlocationform_neigborhoods.value.split(",")

        // ==============================================================

        axios({
            method: "POST",
            url: SERVER_URL + 'locations-generator/generate',
            data: payload
        })
        .then(res => {
            newLocationForm._newlocationform_submit_userinput_data.value = JSON.stringify(newLocation)
            newLocationForm._newlocationform_submit_api_data.value = JSON.stringify(res.data)
        })
        .catch(err => {
            newLocationForm._newlocationform_importlocation_failed.checked = true
            console.log(`ERROR IMPORTING LOCATION DATA: ${err.message}`)
        })
        .then(() => {
            newLocationForm.submit()
        })
    })

    function disasbleNewLocationForm() {
        newLocationForm.elements.forEach(element => {
            if (element.className == '_newlocationform-submit') return
            element.disabled = true
        })
    }
}

/** Locations Tab **/
if (URL_PARAMS.get('tab') == null) {
    // code...
}

function getPrimaryLocation() {
    return USER_INPUT_DATA.filter(loc => loc.primaryLocation)[0]
}