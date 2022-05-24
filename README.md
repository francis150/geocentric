# 🌎 Geocentric WP Plugin
A WordPress plugin that pulls all relevant geocentric data and allows you to add all of them to your service area pages via shortcodes.

### Techs Used

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Js](https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E)
![Sass](https://img.shields.io/badge/Sass-CC6699?style=for-the-badge&logo=sass&logoColor=white)
![Xampp](https://img.shields.io/badge/Xampp-F37623?style=for-the-badge&logo=xampp&logoColor=white)
![WordPress](https://img.shields.io/badge/Wordpress-21759B?style=for-the-badge&logo=wordpress&logoColor=white)
![Google Cloud](https://img.shields.io/badge/Google_Cloud-4285F4?style=for-the-badge&logo=google-cloud&logoColor=white)
![Firebase](https://img.shields.io/badge/firebase-ffca28?style=for-the-badge&logo=firebase&logoColor=black)


### Contents

- 🚀 [Installation](#-installation)
- 📃 [License & Activation](#-license--activation)
- 🤔 [Usage](#-usage)
- 👨‍💻 [Component Shortcodes](#-component-shortcodes)
- 🌎 [Google API Key Setup](#-google-api-key-setup)
- 📌 [GBP Place ID](#gbp-place-id)
- 🚩 [Changelog](CHANGELOG.md)
- 🙋‍♂️ [Developers](#%EF%B8%8F-developers)

<p>&nbsp;</p>

---

<p>&nbsp;</p>

## 🚀 Installation

1. After completing your order from [SEO Rocket](http://seorocket.dev/), you will receive an email with the download link and your license key. <p>![Download Button](https://i.ibb.co/wWR68jC/download-link.png)</p>

2. After downloading your .zip file from the download link in your email, go to your WordPress site, and go to `Plugins > Add New > Upload Plugin`

3. Click `Choose File` and select your downloaded .zip file from Step 1. <p>![Choose File](https://i.ibb.co/dmSXVLb/choose-image.png)</p>

4. Click `Install Now`.

5. And finally Click `Activate Plugin` <p>![Activate Plugin](https://i.ibb.co/PxY5NGK/image-1.png)</p>

6. All Good! 👍

<p>&nbsp;</p>

[Back To The Top](#-geocentric-wp-plugin)

<p>&nbsp;</p>

---

<p>&nbsp;</p>

## 📃 License & Activation

1. Go to your WordPress Website and go to `Geocentric > License Settings` <p>![License Settings](https://i.ibb.co/1ZDkQ0w/image-24.png)</p>

2. Copy the licsense key included in your order email. <p>![License Key](https://i.ibb.co/XJXpzLg/Group-77.png)</p>

3. Paste it into the `License Settings` page & hit Activate License. <p>![Paste License](https://i.ibb.co/16PvPqV/image-26.png)</p>

4. All Good! 👍

<p>&nbsp;</p>

[Back To The Top](#-geocentric-wp-plugin)

<p>&nbsp;</p>

---

<p>&nbsp;</p>

## 🤔 Usage

1. After installing the plugin, open up the dashboard and it will redirect you to the `Settings` tab. You can not proceed if you dont setup the settings first. From here, enter your **Primary Keyword** without any location. Also enter your **Business Name.** If you have a Google Business Profile, it would be better if you could enter in the exact name of your GBP. <p>![Settings Tab](https://i.imgur.com/0FetC8e.png)</p><p>After setting up your settings page, the next step is the `Locations` tab. </p><p>![Locations Tab](https://i.imgur.com/dbiVSOj.png)</p>

2. In the `Locations` tab, you need to add your **Service Areas** and to do that click the `Add Location` button at the top right corner. <p>![Add Location Button](https://i.imgur.com/0pTVMBF.png)</p>

3. It will then take you to the `Create New Location` form. From here, select from the three dropdowns the `Country`, `State`, and `City` of your Service Area. <p>![Select Location](https://i.imgur.com/jUAX4Dj.png)</p>

4. After choosing from the `City` dropdown, The `neighborhoods` text area will load up all available neighborhoods data we have on our database. Some locations may have a lot, some may have few, and some may have none. The `neighborhoods` text area is completely editable. You can add or remove any neighborhoods as you please. Just make sure to separate each with commas. <p>![Neighborhoods](https://i.imgur.com/bcKB1vb.png)</p><p>We are still currently working on adding data to our database as we'd love to cater as much of our subscribers as possible. If you want to request for a location to be added, just email us at seorockettools@gmail.com or write a support ticket at <a href="https://support.seorocket.dev/" target="_blank">our supoprt channel</a>.</p>

5. The `GBP Place ID` is the next field. Although it is not required, it is recommended that you enter a Place ID **IF AND ONLY IF** you have a GBP in that city. This will be used to pull in the reviews from your GBP. If you dont have a GBP in this city, **DO NOT** enter anything. <p>![GBP Place ID](https://i.imgur.com/8nvAT4r.png)</p>

6. Click `Create` button at the buttom and wait for the plugin to pull in all the geocentric data. <p>![Create Button](https://i.imgur.com/knOBeiw.png)</p>

7. After creating a Service Area or a Location, click the `shortcodes` icon to show the shortcodes. <p>![Shortcodes](https://i.imgur.com/GePXkM0.png)</p>

8. All that's left now is to copy the `shortcodes` and paste them into your Service Area Pages. <p>![Copy Shortcodes](https://i.imgur.com/ZaRQjgD.png)</p>

9. Done! 👌

<p>&nbsp;</p>

[Back To The Top](#-geocentric-wp-plugin)

<p>&nbsp;</p>

---

<p>&nbsp;</p>

## 👨‍💻 Component Shortcodes

*All shortcodes has a required attribute `id` which is used to reference your shortcodes from your multiple locations.*

<p>&nbsp;</p>

### **Weather Component** - `[geocentric_weather]`

Shows the temperature, and weather in that area for the day and 7 days ahead. <p>![](https://i.ibb.co/FY4SbqS/image-36.png)</p>


<p>&nbsp;</p>

### **About Component** - `[geocentric_about]`

Shows a paragraph of all the information about the location. <p>![](https://i.ibb.co/5jQ0qLz/image-37.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.

<p>&nbsp;</p>

### **Neighborhoods Component** - `[geocentric_neighborhoods]`

Shows a list of all the neighborhoods in that location and is linked to google maps whenever it is clicked. <p>![](https://i.ibb.co/5KqcmXm/image-38.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.

<p>&nbsp;</p>

### **Things to Do Component** - `[geocentric_thingstodo]`

Shows all the top sights in that location together with their ratings. <p>![](https://i.ibb.co/2j16y0R/image-39.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.
- `hide_ratings` - *(optional)* Wether or not to display the rating
- `limit` - *(optional)* Limit the number of items to display
- `alt` - *(optional)* image alt texts

<p>&nbsp;</p>

### **Bus Stops Component** - `[geocentric_busstops]`

Show a grid of bus stops in the city increasing your proximity. <p>![Bus Stops Component](https://i.imgur.com/PZILXuA.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.
- `limit` - *(optional)* Limit the number of items to display

<p>&nbsp;</p>

### **Map Embed Component** - `[geocentric_mapembed]`

Embeds Google Map of that location. <p>![](https://i.ibb.co/56F82V7/image-40.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.

<p>&nbsp;</p>

### **Driving Directions** - `[geocentric_drivingdirections]`

Shows a grid of maps with driving directions from your compitetors to your business sending traffic to google making it look like unsatisfied customers driving from your compitetor's business to yours. <p>![](https://i.imgur.com/pUYyCyh.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.
- `limit` - *(optional)* Limit the number of items to display

<p>&nbsp;</p>

### **Reviews** - `[geocentric_reviews]`

Shows the reviews of your GMB Listing in that area if available, if not, it shows the reviews of your GMB Listing on your Primary Location. <p>![](https://i.ibb.co/s1xs4X7/image-42.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.
- `limit` - *(optional)* Limit the number of reviews to display

<p>&nbsp;</p>

[Back To The Top](#-geocentric-wp-plugin)

<p>&nbsp;</p>

---

<p>&nbsp;</p>

## 🌎 Google API Key Setup 

*For Geocentric Plugins that are purchased via <a href="http://seorocket.dev/" target="_blank">http://seorocket.dev/</a>, we do not require any Google API Key anymore and this step is not necessary.*

### **Getting Started**
 
1. Navigate to the [Google Maps Platform](https://developers.google.com/maps) and click on the Get Started button in the top right corner of the site. <p>![Get Started](https://i.imgur.com/IGIeZaA.png)</p>

2. Set up your billing
Select your country and accept Terms of Service. Click Continue.<p>![Get Started](https://i.imgur.com/9LrEuq9.png)</p>

3. Enter your mobile number. <p>![Mobile Number](https://i.imgur.com/hupVT67.png)</p>

4. Enter your customer info (details) and card information. <p>![Card Info](https://i.imgur.com/BkEZMKp.png)</p>

5. Select START MY FREE TRIAL. <br><br> Please note that you have a 12-month or $300 credit free trial. When this free trial ends, you will get up to 28 000 map requests per month and 40 000 direction calls per month, free of charge. You will only be billed when your usage exceeds your monthly $200 credit limit.
For more information about the free trial, please refer to [Google’s documentation](https://cloud.google.com/free/docs/gcp-free-tier).
Once your billing has been set up, you can move on to creating your API Key.

<p>&nbsp;</p>

### **Creating Your Cloud Console Project**

Go to your [Google Cloud Console Dashboard](https://console.cloud.google.com/home/dashboard)

1. Select the current project as shown below. <p>![Start Project](https://i.imgur.com/GF821HD.png)</p> 

2. Create a New Project <p>![Create Project](https://i.imgur.com/292WrW3.png)</p>

3. Name Your Project <p>![Create Project](https://i.imgur.com/b2lBUJo.png)</p>

4. After creating your project go back to your dashboard and click `Go to APIs overview` <p>![Go To APIs Overview](https://i.imgur.com/iF47yYw.png)</p>

5. Click `Enable APIS AND SERVICES` <p>![Enable APIS](https://i.imgur.com/43WXp15.png)</p>

6. In The API Library Search For The API you will be enabling for the project <p>![search apis](https://i.imgur.com/Chr70t2.png) Here are a list of API's you will need for the Locations Plugin 
    - Places API
    - Maps JavaScript API
    - Knowledge Graph Search API
    - Geo Coding API
    - Directions API </p>

7. Click the API you are searching for. <p>![Click API](https://i.imgur.com/NZYWE71.png)</p>

8. Click Enable To Use That API <p>![Enable API](https://i.imgur.com/6xkNDos.png) *Please Make sure you have enable required API's enabled For The Plugin To Work!*</p>

***NOTE:** For the plugin to work properly you have to set up your billing info inside the Google Cloud Console.*

<p>&nbsp;</p>

[Back To The Top](#-geocentric-wp-plugin)

<p>&nbsp;</p>

---

<p>&nbsp;</p>

## 📌GBP Place ID

*There are a number of ways to find your Google Business Profile's Place ID.*

<p>&nbsp;</p>

### Google Place ID Finder

Head over to googles <a href="https://developers.google.com/maps/documentation/javascript/examples/places-placeid-finder" target="_blank">Place ID Finder</a> and search for your Google Business Profile.

![Place ID Finder](https://i.imgur.com/YHB7mRL.png)

This should show a pin on your GBP with your Place ID with it.

<p>&nbsp;</p>

### GatherUp Chrome Extension

Install the <a href="https://chrome.google.com/webstore/detail/gatherup-google-review-li/cledombdgacmpceceadogfpacbhfehlf" target="_blank">GatherUp chrome extension</a> and go to your Google Business Profile.

![](https://i.imgur.com/NBSc8E2.png)

When you're in your GBP, click the GatherUp icon in your chrome extensions menu on the top right corner of your Chrome Browser.

![](https://i.imgur.com/GujyfrD.png)

This should take you to a page where you can see your CID Link and Place ID Link. Extract your Place ID from the Place ID Link just as seen in the image above.

<p>&nbsp;</p>

[Back To The Top](#-geocentric-wp-plugin)

<p>&nbsp;</p>

---

<p>&nbsp;</p>

## 🙋‍♂️ Developers

### Francis Dela Victoria
- [Facebook](https://www.facebook.com/iscothevictory/)
- [Email](mailto:francisdelavictoria150@gmail.com)

### Paul Bryan Reyes
- [Facebook](https://www.facebook.com/seyluap)
- [Email](mailto:pbreyes63937@gmail.com)

<p>&nbsp;</p>

[Back To The Top](#-geocentric-wp-plugin)

<p>&nbsp;</p>

---

© Powered by [SEO Rocket](http://seorocket.dev/) 2021 🤟.
