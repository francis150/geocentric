# 🚩 Geocentric Changelog

[Back to README](https://github.com/francis150/geocentric#-geocentric-wp-plugin)

<p>&nbsp;</p>

## 🎯 v2.0.0

### ❗ **IMPORTANT NOTE**
THIS UPDATE WILL WIPE OUT ALL YOUR EXCISTING DATA/LOCATION. You will have to add back all your locations after this update.

### 😎 **Updates**
- New Driving Directions Component
    - Driving directions from competitors to your business
- Bus Stops Component (Bus stops to your business)
- Major UI Update
- Only 1 Google API Key Needed

### 🕷 **Bug Fixes**
- Driving Directions **FIXED**
- Irrelevant about us information **FIXED**
- Broken UI on multiple Location import **FIXED**

<p>&nbsp;</p>

## 🎯 v1.0.5

### 🕷 **Bug Fixes**

- Dashboard UI Missing Issue Fixed

<p>&nbsp;</p>

## 🎯 v1.0.4

### 🕷 **Bug Fixes**

- API Data Compatability Issue Fixed

<p>&nbsp;</p>

## 🎯 v1.0.3

### 😎 **Updates**

- Server changed to server_v2
- Changed neigbourhoods to neighborhoods

<p>&nbsp;</p>

## 🎯 v1.0.2

### 😎 **Updates**

- Added `unit` attribute to Weather Component for choosing between Celsius and Fahrenheit. Read docs [here](https://github.com/francis150/geocentric#:~:text=unit%20%2D%20(optional)%20Use%20C%20for%20Celsius%20and%20F%20for%20Fahrenheit.) on how to use `unit` attribute.

<p>&nbsp;</p>

## 🎯 v1.0.1

### 😎 **Updates**

- **Added dedicated Google API Key for Driving Directions** - The Driving Directions Components uses your Google API Key in the front-end and can be visible to the public. In this update users are required to provide 2 Google API Keys;

    - `Unrestricted API Key` - This API Key will be used on our servers to pull the necessary data needed for the **About Component**, **Neighborhoods Component**, and **Things to Do Component**. This API Key must be unrestricted for our server to use it. **Required API Services;** 
        - Places API
        - Geo Coding API
        - Knowledge Graph Search API
        
        <br>

    - `Restricted API Key` - This API Key will be used specifically only by the **Driving Directions Component** and will be visible to the Public. This API Key must be restricted for it to be used only by your domain. **Required API Services;** 
        - Maps JavaScript API
        - Directions API

<p>&nbsp;</p>

## 🎯 v1.0.0 Initial Release

### 😎 **Updates**

- Extremely Cheap Google API Pulls
- No Component Load Time
- Improved UI and User Experience

### 🕷 **Bug Fixes**

- Fixed Neighbourhoods Data Accuracy
- Fixed Things To Do Results Accuracy
- Fixed Location GMB Map Embed Accuracy
- Reworked Component Stylings
- Reworked Weather Widget (No Longer Requires Weather API)
- Reworked About Component
- Reworked Directions Component

<p>&nbsp;</p>

[Back To The Top](#-geocentric-changelog)

---

© Powered by [RankFortress](https://rankfortress.com/) 2021 🤟.
