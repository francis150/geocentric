

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

    if (document.querySelector('._geocentric-main .newlocation-form .newlocation-form-advance-options').checked) 
    document.querySelector('._geocentric-main .newlocation-form .newlocation-form-advance-options').click()
}
document.querySelector('._geocentric-main .newlocation-form .head .close-button').addEventListener('click', () => {
    closeNewLocationForm();
})

// Advance options toggler
document.querySelector('._geocentric-main .newlocation-form .newlocation-form-advance-options').addEventListener('sl-change', (e) => {
    const panel = document.querySelector('._geocentric-main .newlocation-form .advance-options-panel')

    if (e.target.checked) {
        panel.style.height = '180px';
    } else {
        panel.style.height = '0';
    }
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
    editBtn.addEventListener('click', (e) => {
        const locationItem = e.target.parentElement.parentElement.parentElement.dataset

        document.querySelector('._geocentric-main .newlocation-form form .edit_key').value = locationItem.id
        document.querySelector('._geocentric-main .newlocation-form form .city_name').value = locationItem.city_name
        document.querySelector('._geocentric-main .newlocation-form form .state_name').value = locationItem.state_name
        document.querySelector('._geocentric-main .newlocation-form form .country_name').value = locationItem.country_name

        document.querySelector('._geocentric-main .newlocation-form form select.country').innerHTML += `<option selected value="${locationItem.country_iso2}">${locationItem.country_name}</option>`;

        fetchStates(locationItem.country_iso2, () => {
            document.querySelector('._geocentric-main .newlocation-form form select.state').innerHTML += `<option selected value="${locationItem.state_code}">${locationItem.state_name}</option>`;

            fetchCities(locationItem.country_iso2, locationItem.state_code, () => {
                document.querySelector('._geocentric-main .newlocation-form form select.city').innerHTML += `<option selected value="${locationItem.city_id}">${locationItem.city_name}</option>`;
            })
        })

        if (locationItem.neighbourhoods) document.querySelector('._geocentric-main .newlocation-form form .neighborhood').innerHTML = locationItem.neighbourhoods


        if (locationItem.google_place_id || locationItem.driving_directions_limit) document.querySelector('._geocentric-main .newlocation-form form .newlocation-form-advance-options').click()

        if (locationItem.google_place_id) document.querySelector('._geocentric-main .newlocation-form form .google_maps_place_id').value = locationItem.google_place_id
        if (locationItem.driving_directions_limit) document.querySelector('._geocentric-main .newlocation-form form .driving_directions_limit').value = locationItem.driving_directions_limit

        document.querySelector('._geocentric-main .newlocation-form form .head h2').innerHTML = 'Edit Location'
        document.querySelector('._geocentric-main .newlocation-form').style.display = 'flex'
        
    })
})

// Remove Location
document.querySelectorAll('._geocentric-main .main-view-wrapper .main-tab-group .locations-list .location-item .moreoptions-dropdown .remove-location-button').forEach(removeBtn => {
    removeBtn.addEventListener('click', async (e) => {

        if(confirm('Are you sure you want to remove this location?')) {
            const locationItem = await e.target.parentElement.parentElement.parentElement.dataset

            document.querySelector('._geocentric-main .newlocation-form form .remove_key').value = locationItem.id
            document.querySelector('._geocentric-main .newlocation-form form').submit()
        }

    })
})

// Set as main location
document.querySelectorAll('._geocentric-main .main-view-wrapper .main-tab-group .locations-list .location-item .moreoptions-dropdown .main-location-button').forEach(mainLocationBtn => {
    mainLocationBtn.addEventListener('click', async (e) => {
        if (confirm('This Operation will remove all imported data and you will have to re-import them all again. Are you sure you want to set this location as your Primary Location? Would be better if you add a GMB Place ID under Advance Options.')) {
            const locationItem = await e.target.parentElement.parentElement.parentElement.dataset

            document.querySelector('._geocentric-main .newlocation-form form .mainlocation_key').value = locationItem.id
            document.querySelector('._geocentric-main .newlocation-form form').submit()
        }
    })
})




/* ****GEODATABASE***** */

const GEODATABASE_URL = 'https://geodatabase-api.herokuapp.com/api/'

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