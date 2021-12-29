

/* *****LOCATION FORM**** */
// Add New Location Form
document.querySelector('._geocentric-main .main-view-wrapper .locations-panel .add-location-button').addEventListener('click', () =>{
    document.querySelector('._geocentric-main .newlocation-form').style.display = 'flex'
    document.querySelector('._geocentric-main .newlocation-form form .new_key').value = uuidv4()
    document.querySelector('._geocentric-main .newlocation-form form select.country').options[0].selected = true
    document.querySelector('._geocentric-main .newlocation-form form .head h2').innerHTML = 'Add New Location'
})

// Close new location form
function closeNewLocationForm() {
    document.querySelector('._geocentric-main .newlocation-form form').reset()
    document.querySelector('._geocentric-main .newlocation-form').style.display = 'none'

    document.querySelector('._geocentric-main .newlocation-form select.state').innerHTML = '<option value="" selected disabled>---</option>'
    document.querySelector('._geocentric-main .newlocation-form select.city').innerHTML = '<option value="" selected disabled>---</option>'

    document.querySelector('._geocentric-main .newlocation-form textarea.neighborhood').placeholder = ''
    document.querySelector('._geocentric-main .newlocation-form textarea.neighborhood').innerHTML = ''

    document.querySelector('._geocentric-main .newlocation-form .place_id_unavailable').checked = false;
    document.querySelector('._geocentric-main .newlocation-form .pinpoint-address .place_id').style.display = 'flex'
    document.querySelector('._geocentric-main .newlocation-form .pinpoint-address .street_address_zipcode').style.display = 'none'
}
document.querySelector('._geocentric-main .newlocation-form .head .close-button').addEventListener('click', () => {
    closeNewLocationForm();
})

// Toggle place_id to street_addres + zip_code
document.querySelector('._geocentric-main .newlocation-form .pinpoint-address .place_id_unavailable').addEventListener('click', (e) => {
    document.querySelector('._geocentric-main .newlocation-form .pinpoint-address .place_id').style.display = e.target.checked ? 'none' : 'flex'
    document.querySelector('._geocentric-main .newlocation-form .pinpoint-address .street_address_zipcode').style.display = e.target.checked ? 'flex' : 'none'

    document.querySelector('._geocentric-main .newlocation-form .pinpoint-address .street_address').required = e.target.checked
    document.querySelector('._geocentric-main .newlocation-form .pinpoint-address .zip_code').required = e.target.checked
})

// Load States when Country is selected
document.querySelector('._geocentric-main .newlocation-form select.country').addEventListener('change', (e) => {
    document.querySelector('._geocentric-main .newlocation-form select.state').innerHTML = '<option value="" selected>Loading...</option>'
    document.querySelector('._geocentric-main .newlocation-form select.city').innerHTML = '<option value="" selected disabled>---</option>'
    document.querySelector('._geocentric-main .newlocation-form textarea.neighborhood').placeholder = ''
    document.querySelector('._geocentric-main .newlocation-form textarea.neighborhood').innerHTML = ''

    document.querySelector('._geocentric-main .newlocation-form .country_name').value = e.target.options[e.target.selectedIndex].text
    
    fetchStates(e.target.value)
})

// Load Cities when States is selected
document.querySelector('._geocentric-main .newlocation-form select.state').addEventListener('change', (e) => {

    document.querySelector('._geocentric-main .newlocation-form select.city').innerHTML = '<option value="" selected>Loading...</option>'
    document.querySelector('._geocentric-main .newlocation-form textarea.neighborhood').placeholder = ''
    document.querySelector('._geocentric-main .newlocation-form textarea.neighborhood').innerHTML = ''

    document.querySelector('._geocentric-main .newlocation-form .state_name').value = e.target.options[e.target.selectedIndex].text

    fetchCities(document.querySelector('._geocentric-main .newlocation-form select.country').value, e.target.value)
})

// Load City Data when selected
document.querySelector('._geocentric-main .newlocation-form select.city').addEventListener('change', (e) => {
    document.querySelector('._geocentric-main .newlocation-form textarea.neighborhood').placeholder = 'Loading...'
    document.querySelector('._geocentric-main .newlocation-form textarea.neighborhood').innerHTML = ''

    document.querySelector('._geocentric-main .newlocation-form .city_name').value = e.target.options[e.target.selectedIndex].text

    fetchCity(document.querySelector('._geocentric-main .newlocation-form select.country').value, document.querySelector('._geocentric-main .newlocation-form select.state').value, e.target.value)
})


/* *****LOCATION LIST**** */
// Edit location
document.querySelectorAll('._geocentric-main .main-view-wrapper .main-tab-group .locations-list .location-item .moreoptions-dropdown .edit-location-button').forEach(editBtn => {
    editBtn.addEventListener('click', () => {
        const locationItem = editBtn.parentElement.parentElement.parentElement.dataset

        document.querySelector('._geocentric-main .newlocation-form form .edit_key').value = locationItem.id
        document.querySelector('._geocentric-main .newlocation-form form .city_name').value = locationItem.city_name
        document.querySelector('._geocentric-main .newlocation-form form .state_name').value = locationItem.state_name
        document.querySelector('._geocentric-main .newlocation-form form .country_name').value = locationItem.country_name

        if (locationItem.primary_location) document.querySelector('._geocentric-main .newlocation-form form .is_primary').value = locationItem.primary_location
        if (locationItem.google_place_id) document.querySelector('._geocentric-main .newlocation-form form .google_maps_place_id').value = locationItem.google_place_id

        if (locationItem.street && locationItem.zip_code) {
            document.querySelector('._geocentric-main .newlocation-form form .place_id_unavailable').click()
            document.querySelector('._geocentric-main .newlocation-form form .street_address').value = locationItem.street
            document.querySelector('._geocentric-main .newlocation-form form .zip_code').value = locationItem.zip_code
        }

        if (locationItem.neighbourhoods) document.querySelector('._geocentric-main .newlocation-form form .neighborhood').innerHTML = locationItem.neighbourhoods

        document.querySelector('._geocentric-main .newlocation-form form select.country').innerHTML += `<option selected value="${locationItem.country_iso2}">${locationItem.country_name}</option>`;

        fetchStates(locationItem.country_iso2, () => {
            document.querySelector('._geocentric-main .newlocation-form form select.state').innerHTML += `<option selected value="${locationItem.state_code}">${locationItem.state_name}</option>`;

            fetchCities(locationItem.country_iso2, locationItem.state_code, () => {
                document.querySelector('._geocentric-main .newlocation-form form select.city').innerHTML += `<option selected value="${locationItem.city_id}">${locationItem.city_name}</option>`;
            })
        })

        document.querySelector('._geocentric-main .newlocation-form form .head h2').innerHTML = 'Edit Location'
        document.querySelector('._geocentric-main .newlocation-form').style.display = 'flex'
        
    })
})

// Remove Location
document.querySelectorAll('._geocentric-main .main-view-wrapper .main-tab-group .locations-list .location-item .moreoptions-dropdown .remove-location-button').forEach(removeBtn => {
    removeBtn.addEventListener('click', () => {

        if(confirm('Are you sure you want to remove this location?')) {
            const locationItem = removeBtn.parentElement.parentElement.parentElement.dataset

            document.querySelector('._geocentric-main .newlocation-form form .remove_key').value = locationItem.id
            document.querySelector('._geocentric-main .newlocation-form form').submit()
        }

    })
})

// Set as main location
document.querySelectorAll('._geocentric-main .main-view-wrapper .main-tab-group .locations-list .location-item .moreoptions-dropdown .main-location-button').forEach(mainLocationBtn => {
    mainLocationBtn.addEventListener('click', async (e) => {
        if (confirm('This Operation will remove all imported data and you will have to re-import them all again. Are you sure you want to set this location as your Primary Location? Would be better if you add a GMB Place ID.')) {
            const locationItem = mainLocationBtn.parentElement.parentElement.parentElement.dataset

            document.querySelector('._geocentric-main .newlocation-form form .mainlocation_key').value = locationItem.id
            document.querySelector('._geocentric-main .newlocation-form form').submit()
        }
    })
})

// Import single data
document.querySelectorAll('._geocentric-main .main-view-wrapper .main-tab-group .locations-list .location-item .moreoptions-dropdown .import-data-button').forEach(importDataBtn => {
    importDataBtn.addEventListener('click', () => {
        const primaryLocation = get_primary_location()
        if (!primaryLocation) return alert('Please choose your Primary Location before importing data.')

        const locationItem = importDataBtn.parentElement.parentElement.parentElement
        const locationData = locationItem.dataset
        const hiddenForm = document.querySelector('._geocentric-main .hidden-form form')

        document.querySelector('._geocentric-main .loading-screen').style.display = 'flex'
        document.querySelector('._geocentric-main .loading-screen p').innerHTML = 'Requesting 1 Location Data out of 1...'

        const payload = {
            requesting_domain : importDataBtn.dataset.site_domain,
            id: locationData.id,
            city: {
                id: locationData.city_id,
                name: locationData.city_name
            },
            state: {
                name: locationData.state_name,
                code: locationData.state_code
            },
            country: {
                name: locationData.country_name,
                iso2: locationData.country_iso2
            },
            appsero_info: {
                appsero_api_key: importDataBtn.dataset.appsero_api_key,
                appsero_plugin_name: importDataBtn.dataset.appsero_plugin_name,
            },
            google_api_key: importDataBtn.dataset.google_api_key,
            mainLocation: primaryLocation
        }

        if (locationData.google_place_id) payload['place_id'] = locationData.google_place_id

        axios({
            method: 'POST',
            url: importDataBtn.dataset.api_server_url + 'locations-generator/generate',
            data: payload
        })
        .then(res => {
            hiddenForm._single_api_data.value = JSON.stringify(res.data)
            hiddenForm.submit()
        })
        .catch(err => {
            hiddenForm._api_request_failed.value = JSON.stringify(err.response.data)
            hiddenForm.submit()
        })
    }) 
})

// Import All Data
document.querySelector('._geocentric-main .main-view-wrapper .main-tab-group .locations-panel .head ._geocentric_import_all_data').addEventListener('click', (e) => {
    const locationList = document.querySelectorAll('._geocentric-main .main-view-wrapper .main-tab-group .locations-panel .locations-list .location-item')
    if (locationList.length < 1) return alert('There are currently no locations added...')

    const primaryLocation = get_primary_location()
    if (!primaryLocation) return alert('Please choose your Primary Location before importing data.')

    const results = {
        success: [],
        failed: [],
        count: 0
    }

    locationList.forEach( locationItem => {
        const locationData = locationItem.dataset

        const payload = {
            requesting_domain : e.target.dataset.site_domain,
            id: locationData.id,
            city: {
                id: locationData.city_id,
                name: locationData.city_name
            },
            state: {
                name: locationData.state_name,
                code: locationData.state_code
            },
            country: {
                name: locationData.country_name,
                iso2: locationData.country_iso2
            },
            appsero_info: {
                appsero_api_key: e.target.dataset.appsero_api_key,
                appsero_plugin_name: e.target.dataset.appsero_plugin_name,
            },
            google_api_key: e.target.dataset.google_api_key,
            mainLocation: primaryLocation
        }

        if (locationData.google_place_id) payload['place_id'] = locationData.google_place_id

        const hiddenForm = document.querySelector('._geocentric-main .hidden-form form')

        document.querySelector('._geocentric-main .loading-screen').style.display = 'flex'
        document.querySelector('._geocentric-main .loading-screen p').innerHTML = `${results.count} of ${locationList.length} imported...`

        axios({
            method: 'POST',
            url: e.target.dataset.api_server_url + 'locations-generator/generate',
            data: payload
        })
        .then(res => {
            results.success.push(res.data)
        })
        .catch(err =>{
            results.failed.push(locationData.id)
        })
        .then(() => {

            results.count++
            document.querySelector('._geocentric-main .loading-screen p').innerHTML = `${results.count} of ${locationList.length} imported...`

            if (results.count === locationList.length) {
                hiddenForm._bulk_api_data.value = JSON.stringify(results)
                hiddenForm.submit()
            }
            
        })
    })
})


// Copy short code
document.querySelectorAll('._geocentric-main .main-view-wrapper .main-tab-group .locations-list .location-item .shortcodes-dropdown sl-menu-item').forEach(copyBtn => {
    copyBtn.addEventListener('click', (e)  => {
        const container = document.getElementById('_copy_shortcode')

        container.value = e.target.dataset.shortcode

        container.select()
        container.setSelectionRange(0, 99999)
        navigator.clipboard.writeText(container.value);
    })
})


function get_primary_location() {
    let res
    document.querySelectorAll('._geocentric-main .main-view-wrapper .main-tab-group .locations-list .location-item').forEach(locationItem => {
        if (locationItem.dataset.primary_location) {
            res = {
                country_iso2: locationItem.dataset.country_iso2,
                state_code: locationItem.dataset.state_code,
                city: {
                    name: locationItem.dataset.city_name,
                    id: locationItem.dataset.city_id
                }
            }

            if (locationItem.dataset.google_place_id) res['place_id'] = locationItem.dataset.google_place_id
            if (locationItem.dataset.street) res['street'] = locationItem.dataset.street
            if (locationItem.dataset.zip_code) res['zip_code'] = locationItem.dataset.zip_code
        }
    })

    return res
}


/* ****GEODATABASE***** */

const GEODATABASE_URL = 'https://geo-database-api.herokuapp.com/api/'

// Fetch States
function fetchStates(country, callback = () => {}) {
    fetch(`${GEODATABASE_URL}countries/${country}/states`, {
        method: 'GET'
    })
    .then(res => res.text())
    .then(states => {

        if (JSON.parse(states).length) {
            document.querySelector('._geocentric-main .newlocation-form select.state').innerHTML = '<option value="" selected disabled>Choose a state...</option>'
        } else {
            document.querySelector('._geocentric-main .newlocation-form select.state').innerHTML = '<option  value="" selected>Not data available...</option>'
            document.querySelector('._geocentric-main .newlocation-form select.state').disabled = false
            return
        }
        
        JSON.parse(states).forEach(state => {
            const option = document.createElement('option')
            option.value = state.code
            option.innerHTML = state.name

            document.querySelector('._geocentric-main .newlocation-form select.state').appendChild(option)
        })

        document.querySelector('._geocentric-main .newlocation-form select.state').disabled = false

        callback()
    })
    .catch(err => console.log('ERROR:', err))
}

// Fetch Cities
function fetchCities(country, state, callback = () => {}) {
    fetch(`${GEODATABASE_URL}countries/${country}/states/${state}/cities`, {
        method: 'GET'
    })
    .then(res => res.text())
    .then(cities => {

        if (JSON.parse(cities).length) {
            document.querySelector('._geocentric-main .newlocation-form select.city').innerHTML = '<option value="" selected disabled>Choose a city...</option>'
        } else {
            document.querySelector('._geocentric-main .newlocation-form select.city').innerHTML = '<option value="" selected>Not available...</option>'
            return
        }
        

        JSON.parse(cities).forEach(city => {
            const option = document.createElement('option')
            option.value = city.id
            option.innerHTML = city.name

            document.querySelector('._geocentric-main .newlocation-form select.city').appendChild(option)
        })

        document.querySelector('._geocentric-main .newlocation-form select.city').disabled = false

        callback()
    })
    .catch(err => console.log('ERROR:', err))
}

// Fetch City
function fetchCity(country, state, city) {
    
    fetch(`${GEODATABASE_URL}countries/${country}/states/${state}/cities/${city}`, {
        method: 'GET'
    })
    .then(res => res.text())
    .then(city => {
        if (JSON.parse(city).neighbourhoods.length !== 0) {
            document.querySelector('._geocentric-main .newlocation-form textarea.neighborhood').innerHTML = JSON.parse(city).neighbourhoods.toString()
        } else {
            document.querySelector('._geocentric-main .newlocation-form textarea.neighborhood').placeholder = 'There are no neighbourhoods for this area on our database.'
        }
    })
    .catch(err => console.log('ERROR: ', err))
}