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
- 📃 License & Activation
- 🌎 Google API Key Setup
- 🤔 Usage
- 👨‍💻 Component Shortcodes
    - Weather Component
    - About Component
    - Neighbourhoods Component
    - Things to Do Component
    - Map Embed Component
    - Driving Directions Component
    - Reviews Component
- 🚩 Changelog
- 🙋‍♂️ Developers

<p>&nbsp;</p>

---

<p>&nbsp;</p>

## 🚀 Installation

1. After completing your order from [RankFortress](https://rankfortress.com/product-category/gmb-tools/), you will receive an email with the download link and your license key. You can also download here for [Lifetime](https://github.com/francis150/rank-schema-plugin/releases/download/v3.0.0/rank-schema-lifetime.zip) & [Monthly](https://github.com/francis150/rank-schema-plugin/releases/download/v3.0.0/rank-schema-monthly.zip) <p>![Download Button](https://i.ibb.co/wWR68jC/download-link.png)</p>

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

## 🌎 Google API Key Setup

<p>&nbsp;</p>

[Back To The Top](#-geocentric-wp-plugin)

<p>&nbsp;</p>

---

<p>&nbsp;</p>

## 🤔 Usage

1. After activating your plugin license, you will be prompted into a Welcome Screen, and all you have to do from there is enter your `Google API key` press the `Get Started` button. <p>![Google API Key Input](https://i.ibb.co/HDNNTkZ/image-27.png)</p>

2. After Entering your Google API Key, you will be prompted to the dashboard. Next thing to do is Add your service areas to the list. You can do that by hitting the `Add Service Area` button and a form will pop up. <p>![Add service area button](https://i.ibb.co/fxVmJJw/Group-79-1.png)</p>

3. On the form, set your location by choosing from the three dropdowns(country, state, city). <p>![](https://i.ibb.co/RBLsNNY/Group-78-1.png)</p>

4. Once you set your location, the `Neighbourhoods` text box will be propagated with the neighbourhoods data we've pulled from google. You can `Add` or `Remove` your own neighbourhoods to the text box as long as you separate them with commas(,) <p>![](https://i.ibb.co/cFwvj30/image-30.png)</p>

5. For the `Google Maps Place ID` section, if a GMB Listing is available for this location, you can add the Place ID here. If you have a physical branch in this location but dont have a GMB Listing, you can tick the `Use street address and zip code` checkbox and enter your `Street Address` and `ZIP Code`. After that you can  <p>![](https://i.ibb.co/xSg5gCL/image-31.png)</p>

6. For the sake of the demo, I've added 2 locations to the list. So now, the next thing you need to do is that we need to set your primary location. To do that, Hit the three dots `more icon`, and hit `Set as Primary Location`. <p>![](https://i.ibb.co/gDTXqzC/Group-80-1.png)</p>


7. After all of that, all we need to do now is to import all the data from our server into your website. There are two ways to do that; import them one by one, or import them all together. To import them one by one, you can hit the `More Button > Import Data`. To import them all together, you can hit the `Import All Data Button`. Both of these buttons does not work if you haven't set up your Primary Location. <p>![](https://i.ibb.co/F39JJtT/Group-80-2.png)</p>

8. After the data is pulled from our server, you can see from the green indicators marked `Available` which means that the data is now available in your website. Also, the `Code Icon` will be enabled, and when you click it, you can see the different shortcodes for each components. You can click them to copy the shortcodes instantly. <p>![](https://i.ibb.co/VtyfFTm/Group-81.png)</p>

9. Now, all that is left to do is use it on your actual location page. To do that just simply copy the component shortcode that you want (in my case, I clicked `Copy All Components` to copy all components) and paste the shortcodes to wherever part of the page you want it to be placed. <p>![](https://i.ibb.co/QPXBzxN/image-35.png)</p>

10. Hit Save and you're All Good! 👍

<p>&nbsp;</p>

[Back To The Top](#-geocentric-wp-plugin)

<p>&nbsp;</p>

---

<p>&nbsp;</p>

## 👨‍💻 Component Shortcodes

*All shortcodes has a required attribute `id` which is used to reference your shortcodes from your multiple locations.*

<p>&nbsp;</p>

### **Weather Component** - `[geocentric-weather]`

Shows the temperature, and weather in that area for the day and 7 days ahead. <p>![](https://i.ibb.co/FY4SbqS/image-36.png)</p>

<p>&nbsp;</p>

### **About Component** - `[geocentric-about]`

Shows a paragraph of all the information about the location. <p>![](https://i.ibb.co/5jQ0qLz/image-37.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.

<p>&nbsp;</p>

### **Neighbourhoods Component** - `[geocentric-neighbourhoods]`

Shows a list of all the neighbourhoods in that location and is linked to google maps whenever it is clicked. <p>![](https://i.ibb.co/5KqcmXm/image-38.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.

<p>&nbsp;</p>

### **Things to Do Component** - `[geocentric-thingstodo]`

Shows all the top sights in that location together with their ratings. <p>![](https://i.ibb.co/2j16y0R/image-39.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.
- `hide_ratings` - *(optional)* Wether or not to display the rating
- `limit` - *(optional)* Limit the number of items to display
- `alt` - *(optinal)* image alt texts

<p>&nbsp;</p>

### **Map Embed Component** - `[geocentric-mapembed]`

Embeds Google Map of that location. <p>![](https://i.ibb.co/56F82V7/image-40.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.

<p>&nbsp;</p>

### **Driving Directions** - `[geocentric-drivingdirections]`

Embeds a map with the driving directions from multiple points of that location to your primary location. <p>![](https://i.ibb.co/9y27kqj/image-41.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.

<p>&nbsp;</p>

### **Reviews** - `[geocentric-reviews]`

Shows the reviews of your GMB Listing in that area if available, if not, it shows the reviews of your GMB Listing on your Primary Location. <p>![](https://i.ibb.co/s1xs4X7/image-42.png)</p>

#### **Attributes**

- `title` - *(optional)* changes the title of the section.
- `limit` - *(optional)* Limit the number of reviews to display
- `items-on-desktop` - *(optional)* items to show per page on desktop
- `items-on-tablet` - *(optional)* items to show per page on tablet
- `items-on-mobile` - *(optional)* items to show per page on mobile

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

© Powered by [RankFortress](https://rankfortress.com/) 2021 🤟.