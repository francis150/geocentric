

const URL_PARAMS = new URLSearchParams(window.location.search)

if (URL_PARAMS.get('page') == '_geocentric') {

    document.querySelector('._geocentric-wrapper').style.display = 'inherit'

    const MAIN_WRAPPER_DATA = document.querySelector('._geocentric-wrapper').dataset

    const SERVER_URL = MAIN_WRAPPER_DATA.api_server_url
    const GEODATABASE_URL = MAIN_WRAPPER_DATA.geodatabase_url
    const APPSERO_API_KEY = MAIN_WRAPPER_DATA.appsero_api_key
    const APPSERO_PLUGIN_NAME = MAIN_WRAPPER_DATA.appsero_plugin_name
    const PRIMARY_KEYWORD = MAIN_WRAPPER_DATA.primary_keyword
    const PRIMARY_LOCATION = MAIN_WRAPPER_DATA.primary_location ? JSON.parse(MAIN_WRAPPER_DATA.primary_location) : undefined


    /** Styling Tab **/
    if (URL_PARAMS.get('tab') == 'styling' && PRIMARY_KEYWORD) {
        
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
    if (URL_PARAMS.get('tab') == 'new-location-form' && PRIMARY_KEYWORD) {

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
                headers: {'api_key': '629262de4c6006162d782135'}
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
                headers: {'api_key': '629262de4c6006162d782135'}
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
                headers: {'api_key': '629262de4c6006162d782135'}
            })
            .then(res => {
                
                if (!Array.isArray(res.data)) return selectCityElement.innerHTML = `<option value="" selected disabled>No data available...</option>`

                selectCityElement.innerHTML = `<option value="" selected disabled>Choose a city...</option>`

                res.data.forEach(city => {
                    const cityOption = document.createElement('option')
                    cityOption.value = city._id
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
            neighborhoodsTextArea.disabled = true
            neighborhoodsTextArea.innerHTML = ''
            neighborhoodsTextArea.placeholder = 'Loading...'

            selectCityElement.dataset.cityName = selectCityElement.options[selectCityElement.selectedIndex].text

            const payload = {
                city: {
                    name: selectCityElement.options[selectCityElement.selectedIndex].text,
                    id: selectCityElement.value
                },
                state: {
                    code: selectStateElement.value,
                    name: selectStateElement.options[selectStateElement.selectedIndex].text
                },
                country: {
                    iso2: selectCountryElement.value,
                    name: selectCountryElement.options[selectCountryElement.selectedIndex].text
                }
            }

            axios({
                method: "POST",
                url: SERVER_URL + 'locations-generator/generate-neighborhoods',
                data: payload
            })
            .then(res => {
                neighborhoodsTextArea.disabled = false
                neighborhoodsTextArea.placeholder = ''

                if (res.data.length > 0) return neighborhoodsTextArea.innerHTML = res.data.toString()
                
                neighborhoodsTextArea.placeholder = 'No data available...' 
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


            const payload = clean({
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
                place_id: newLocationForm.newlocationform_gbp_placeid.value || undefined,
                street: newLocationForm.newlocationform_street.value || undefined,
                zip_code: newLocationForm.newlocationform_zipcode.value || undefined
            })

            payload.mainLocation = PRIMARY_LOCATION ? clean({
                country_iso2: PRIMARY_LOCATION.country.iso2,
                state_code: PRIMARY_LOCATION.state.code,
                city: PRIMARY_LOCATION.city,
                place_id: PRIMARY_LOCATION.place_id || undefined,
                street: PRIMARY_LOCATION.street || undefined,
                zip_code: PRIMARY_LOCATION.zip_code || undefined
            }) : clean({
                country_iso2: payload.country.iso2,
                state_code: payload.state.code,
                city: payload.city,
                place_id: payload.place_id || undefined,
                street: payload.street || undefined,
                zip_code: payload.zip_code || undefined
            })

            // ==============================================================
            axios({
                method: "POST",
                url: SERVER_URL + 'locations-generator/generate',
                data: payload
            })
            .then(res => {

                res.data.meta = clean({
                    country: payload.country,
                    state: payload.state,
                    city: payload.city,
                    place_id: payload.place_id || undefined,
                    street: payload.street || undefined,
                    zip_code: payload.zip_code || undefined,
                    is_primary: false,
                    neighborhoods: newLocationForm.newlocationform_neigborhoods.value.split(",") || undefined
                })
                
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

        // Set as primary
        function disasbleNewLocationForm() {
            newLocationForm.newlocationform_country.disabled = true
            newLocationForm.newlocationform_state.disabled = true
            newLocationForm.newlocationform_city.disabled = true
            newLocationForm.newlocationform_neigborhoods.disabled = true
            newLocationForm.newlocationform_gbp_placeid.disabled = true
            newLocationForm.newlocationform_street.disabled = true
            newLocationForm.newlocationform_zipcode.disabled = true
            document.querySelector('._geocentric-wrapper .new-location-form .create-button').disabled = true
            document.querySelector('._geocentric-wrapper .new-location-form .discard-button').disabled = true
        }
    }

    /** Locations Tab **/
    if (URL_PARAMS.get('tab') == null && PRIMARY_KEYWORD) {

        const primaryLocationForm = document.querySelector('._geocentric-wrapper .locations-tab .primary-location-form')
        let apiData = primaryLocationForm.current_api_data.value
        apiData = apiData ? JSON.parse(apiData) : undefined;

        // on shortcodes thickbox show
        document.querySelectorAll('._geocentric-wrapper .locations-tab .location .shortcodes-button').forEach(button => {
            button.addEventListener('click', () => {
                const location = button.parentElement
                document.querySelector('#shortcode-tb-wrapper .shortcodes-tb-title').innerHTML = location.dataset.name + ' Shortcodes'
                document.querySelector('#shortcode-tb-wrapper .shortcodes-tb-textarea').value = `[geocentric_weather id="${location.id}"]\n\n[geocentric_about id="${location.id}"]\n\n[geocentric_neighborhoods id="${location.id}"]\n\n[geocentric_thingstodo id="${location.id}"]\n\n[geocentric_busstops id="${location.id}"]\n\n[geocentric_mapembed id="${location.id}"]\n\n[geocentric_drivingdirections id="${location.id}"]\n\n[geocentric_reviews id="${location.id}"]`
            })
        })

        // shortcode copy all button
        document.querySelector('#tb-copy-shortcodes-button').addEventListener('click', (e) => {
            const shortcodeTextArea = e.target.parentElement.children[2]
            shortcodeTextArea.select()
            shortcodeTextArea.setSelectionRange(0, 999999999)
            navigator.clipboard.writeText(shortcodeTextArea.value)
            e.target.innerHTML = 'Copied!'
        })

        // location more options button
        document.querySelectorAll('._geocentric-wrapper .locations-tab .location .options-button').forEach(button => {
            button.addEventListener('click', () => {
                button.children[1].style.display = button.children[1].style.display == 'flex' ? 'none' : 'flex'
            })
        })

        // menu on mouse leave
        document.querySelectorAll('._geocentric-wrapper .locations-tab .location .dropdown-menu').forEach(menu => {
            menu.addEventListener('mouseleave', () => {
                menu.style.display = 'none'
            })
        })

        // location on remove button
        document.querySelectorAll('._geocentric-wrapper .locations-tab .location .remove-location-button').forEach(button => {
            button.addEventListener('click', (e) => {
                if (button.dataset.isPrimary) {
                    e.preventDefault()
                    return alert('The location you are trying to remove is your Primary Location. Please re-assign a Primary Location and try again.')
                }

                if (!confirm('Are you sure you want to remove this location?')) return e.preventDefault()
            })
        })

        // set location as primary
        document.querySelectorAll('._geocentric-wrapper .locations-tab .location .set-as-primary-button').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault()

                if (button.dataset.isPrimary) return alert('This location is already your Primary Location.')
                if (!confirm('Are you sure you want to set this as your Primary Location?')) return

                let primaryLocation = apiData.filter(location => location.id === button.dataset.id)
                primaryLocation = primaryLocation ? primaryLocation[0].meta : undefined
                primaryLocation = primaryLocation ? clean({
                    country_iso2: primaryLocation.country.iso2,
                    state_code: primaryLocation.state.code,
                    city: primaryLocation.city,
                    place_id: primaryLocation.place_id || undefined,
                    street: primaryLocation.street || undefined,
                    zip_code: primaryLocation.zip_code || undefined
                }) : undefined

                if (!primaryLocation) return;

                setPrimaryEventTriggered()

                const iterate = new Promise((resolve, reject) => {
                    const modified = []
                    let count = 0

                    apiData.forEach((location, index) => {

                        let neighborhoods
    
                        if (location.meta.neighborhoods) {
                            neighborhoods = location.meta.neighborhoods
                            delete location.meta.neighborhoods
                            delete location.meta.is_primary
                        }
    
                        const payload = {
                            ...location.meta,
                            requesting_domain: location.domain,
                            id: location.id,
                            appsero_info: {
                                appsero_api_key: APPSERO_API_KEY,
                                appsero_plugin_name: APPSERO_PLUGIN_NAME
                            },
                            primary_keyword: PRIMARY_KEYWORD
                        }
    
                        payload.mainLocation = primaryLocation
    
                        axios({
                            method: "POST",
                            url: SERVER_URL + 'locations-generator/generate',
                            data: payload
                        })
                        .then(async res => {
                            res.data.meta = clean({
                                country: payload.country,
                                state: payload.state,
                                city: payload.city,
                                place_id: payload.place_id || undefined,
                                street: payload.street || undefined,
                                zip_code: payload.zip_code || undefined,
                                neighborhoods: neighborhoods || undefined,
                                is_primary: res.data.id === button.dataset.id
                            })
    
                            modified.push(res.data)
                            count++
                        })
                        .catch(err => {
                            console.log(`ERROR IMPORTING LOCATION DATA: ${err.message}`)  
                        })
                        .then(() => {
                            if (count === apiData.length) resolve(modified)
                        })
                    })
                })

                iterate.then((modified) => {
                    primaryLocationForm.new_primary_api_data.value = JSON.stringify(modified)
                    primaryLocationForm.submit()
                })
            })
        })

        // Re-import location
        document.querySelectorAll('._geocentric-wrapper .locations-tab .location .reimport-button').forEach(button => {
            button.addEventListener('click', e => {
                e.preventDefault()

                button.className = 'reimport-button reimporting'

                let selectedLocation = button.dataset.id
                selectedLocation = apiData.filter(location => location.id === selectedLocation)[0]

                let primaryLocation = apiData.filter(location => location.meta.is_primary === true)
                primaryLocation = primaryLocation.length > 0 ? primaryLocation[0].meta : undefined
                primaryLocation = primaryLocation ? clean({
                    country_iso2: primaryLocation.country.iso2,
                    state_code: primaryLocation.state.code,
                    city: primaryLocation.city,
                    place_id: primaryLocation.place_id || undefined,
                    street: primaryLocation.street || undefined,
                    zip_code: primaryLocation.zip_code || undefined
                }) : clean({
                    country_iso2: selectedLocation.meta.country.iso2,
                    state_code: selectedLocation.meta.state.code,
                    city: selectedLocation.meta.city,
                    place_id: selectedLocation.meta.place_id || undefined,
                    street: selectedLocation.meta.street || undefined,
                    zip_code: selectedLocation.meta.zip_code || undefined
                })

                let neighborhoods
                let is_primary

                if (selectedLocation.meta.neighborhoods) {
                    neighborhoods = selectedLocation.meta.neighborhoods
                    is_primary = selectedLocation.meta.is_primary
                    delete selectedLocation.meta.neighborhoods
                    delete selectedLocation.meta.is_primary
                }

                const payload = clean({
                    ...selectedLocation.meta,
                    requesting_domain: selectedLocation.domain,
                    id: selectedLocation.id,
                    appsero_info: {
                        appsero_api_key: APPSERO_API_KEY,
                        appsero_plugin_name: APPSERO_PLUGIN_NAME
                    },
                    primary_keyword: PRIMARY_KEYWORD,
                    mainLocation: primaryLocation
                })

                axios({
                    method: "POST",
                    url: SERVER_URL + 'locations-generator/generate',
                    data: payload
                })
                .then(res => {
                    res.data.meta = clean({
                        country: payload.country,
                        state: payload.state,
                        city: payload.city,
                        place_id: payload.place_id || undefined,
                        street: payload.street || undefined,
                        zip_code: payload.zip_code || undefined,
                        neighborhoods: neighborhoods || undefined,
                        is_primary
                    })

                    primaryLocationForm.reimported_api_data.value = JSON.stringify(res.data)
                    primaryLocationForm.submit()
                })
                .catch(err => {
                    console.log(`ERROR IMPORTING LOCATION DATA: ${err.message}`)  
                })
                
            })
        })

        
        function setPrimaryEventTriggered() {
            document.querySelector('._geocentric-wrapper .locations-tab .header-wrapper a').href = 'javascript:void(0)'
            document.querySelector('._geocentric-wrapper .locations-tab .header-wrapper button').disabled = true
            document.querySelectorAll('._geocentric-wrapper .locations-tab .location .options-button').forEach(button => {
                button.disabled = true
            })
        }
    }


    function clean(obj) {
        for (var propName in obj) {
            if (obj[propName] === null || obj[propName] === undefined) {
                delete obj[propName];
            }
        }
        return obj
    }
}


