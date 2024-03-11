document.addEventListener("DOMContentLoaded", function() {
    // Get the select element
    const locationSelect = document.getElementById('selLocation');

    // Get the div elements for Reality and Virtual meetings
    const realityDiv = document.getElementById('reality');
    const virtualDiv = document.getElementById('virtual');
    const urlInput = document.getElementById('location-virtual');
    const timeInput = document.getElementById('Time');
    const dateInput = document.getElementById('Date');
    const dateTimeSpan = document.getElementById('DatetimeSpan');
    const scheduleItem1 = document.querySelectorAll('.schedule-item-1');
    const scheduleItem2 = document.querySelectorAll('.schedule-item-2');
    const notificationButtons = document.querySelectorAll('.notification-btn');
    const popoverTrigger = document.querySelector('.popover-dismiss');


    if (popoverTrigger) {
        new bootstrap.Popover(popoverTrigger, {
            trigger: 'focus'
        });
    }

    //date time
    function showDateTimeWarning(element, message){
        element.textContent = message;
        element.classList.remove('hide');
    }

    function hideDateTimeWarning(element){
        element.textContent('');
        element.classList.add('hide');
    }

    function CheckDateTimeOld(){
        const selectedDate = new Date(dateInput.value +'T'+timeInput.value);
        const currentDate = new Date();

        if (selectedDate < currentDate){
            showDateTimeWarning(dateTimeSpan, 'The selected date and time is just old.😲 And it will be save as expired data.')
        }
        else{
            hideDateTimeWarning(dateTimeSpan);
        }
    }


    // Hide both Reality and Virtual divs initially
    realityDiv.style.display = 'none';
    virtualDiv.style.display = 'none';

    // Function to show/hide divs based on selection
    function toggleDivs() {
        const selectedOption = locationSelect.value;
        if (selectedOption === 'reality') {
            realityDiv.style.display = 'block';
            virtualDiv.style.display = 'none';
        } else if (selectedOption === 'virtual') {
            realityDiv.style.display = 'none';
            virtualDiv.style.display = 'block';
        } else {
            realityDiv.style.display = 'none';
            virtualDiv.style.display = 'none';
        }
    }

    // Validate URL
    const pattern = new RegExp(/(https:\/\/www\.|http:\/\/www\.|https:\/\/|http:\/\/)?[a-zA-Z]{2,}(\.[a-zA-Z]{2,})(\.[a-zA-Z]{2,})?\/[a-zA-Z0-9]{2,}|((https:\/\/www\.|http:\/\/www\.|https:\/\/|http:\/\/)?[a-zA-Z]{2,}(\.[a-zA-Z]{2,})(\.[a-zA-Z]{2,})?)|(https:\/\/www\.|http:\/\/www\.|https:\/\/|http:\/\/)?[a-zA-Z0-9]{2,}\.[a-zA-Z0-9]{2,}\.[a-zA-Z0-9]{2,}(\.[a-zA-Z0-9]{2,})?/g);
    const warningText = document.createElement('span');
    warningText.textContent = 'Your URL is unreadable or blank.';
    warningText.style.color = 'red';
    warningText.style.display = 'none'; // Hide at start point

    urlInput.parentNode.appendChild(warningText); // Append the warning text after the input

    function validateUrl() {
        const urlValue = urlInput.value.trim();
        pattern.lastIndex = 0;
        if (pattern.test(urlValue) === false) {
            warningText.textContent = 'Your URL is unreadable or blank.';
            warningText.style.color = 'red';
            warningText.style.display = 'inline';
        } else {
            warningText.textContent = 'URL is valid.';
            warningText.style.color = 'green'; //success is green rwar
            warningText.style.display = 'inline';
        }
    }

    //pasting
    const pasteButton = document.getElementById('paste');
    pasteButton.addEventListener('click', async function(){
        try {
            urlInput.value = await navigator.clipboard.readText();
            validateUrl();
        }catch (error){
            console.error('you are fail to paste text', error);
        }
    })

    //schedule color
    // function setLiBackgroundColor(items, customColors = [], baseColor = '0, 50, 50') {
    //     const totalItems = items.length;
    //
    //     items.forEach((item, index) => {
    //         const intensity = (totalItems - index) / totalItems;
    //         let backgroundColor;
    //
    //         if (customColors[index]) {
    //             backgroundColor = customColors[index];
    //         } else {
    //             backgroundColor = `rgba(${baseColor}, ${intensity})`;
    //         }
    //
    //         // Calculate the brightness of the background color
    //         const brightness = (0.299 * parseInt(backgroundColor.substr(4, 3))) +
    //             (0.587 * parseInt(backgroundColor.substr(9, 3))) +
    //             (0.114 * parseInt(backgroundColor.substr(14, 3)));
    //
    //         // Determine the appropriate text color based on background brightness
    //         const textColor = (brightness > 150) ? 'black' : 'white';
    //
    //         item.style.backgroundColor = backgroundColor;
    //         item.style.color = textColor;
    //     });
    // }



    // setLiBackgroundColor(scheduleItem1, [], '130, 185, 253');
    // setLiBackgroundColor(scheduleItem2, [], '184, 236, 50');




    urlInput.addEventListener('keyup', validateUrl);
    urlInput.addEventListener('keydown', validateUrl);
    urlInput.addEventListener('input', validateUrl);
    locationSelect.addEventListener('change', toggleDivs);
    dateInput.addEventListener('input', CheckDateTimeOld);
    timeInput.addEventListener('input', CheckDateTimeOld);
    toggleDivs();
});
