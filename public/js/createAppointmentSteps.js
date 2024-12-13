/*
    V1.0.0 of searching data

    STEP 1: Get data from services (array of service id and duration)
    STEP 2: Get locations where service can be done
    STEP 3: Select doctor
    STEP 4: Array of appointmnets made in the next year (stored in array with following information, id of service, duration, time start, time end)
    STEP 5: Check the array, if the service can't be fitted, disable the day
    STEP 6: Show the date 

*/

const dayMapping = {
    "Monday": "mon",
    "Tuesday": "tue",
    "Wednesday": "wed",
    "Thursday": "thu",
    "Friday": "fri",
    "Saturday": "sat",
    "Sunday": "sun"
};

const canFit = {}
const services = {}
const timeInterval = {}
const servicesByDate = {}

var availableDates
var unavailableDates
var intervals

let serviceSelected
let serviceDuration

/*
    ========================
    STEP 1: Get services
    ========================
*/

async function fetchServices(url) {
    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();

        // Process the data from the current page
        const servicesData = data.data; // The current page's services
        servicesData.forEach(service => {
            const serviceId = service.id;
            const duration = service.duration;
            const price = service.price;

            // Initialize the serviceId key if not present
            if (!services[serviceId]) {
                services[serviceId] = [];
            }

            // Add duration and price for the service
            services[serviceId].push({ duration, price });
        });

        // Check if there is a next page and recursively fetch
        const nextPage = data.links.next;
        if (nextPage) {
            await fetchServices(nextPage); // Recursively fetch the next page
        }
    } catch (error) {
        console.error('Error fetching services:', error);
    }
}

// Start fetching from the first page
(async () => {
    await fetchServices("http://127.0.0.1:8000/api/v1/services?includeLocation=true");
    // console.log('Final Services:', services); // Log after all fetches are complete
})();

/*
    ========================
    SELECT LOCATION 
    ========================
*/

document.getElementById('service_id').addEventListener('change', function () {
    const appointTypeSelect = document.getElementById('appointment_type');
    const locationSelect = document.getElementById('location_id');
    const doctorSelect = document.getElementById('doctor_id');
    serviceSelected = this.value

    // Enable and reset the appointment type dropdown
    appointTypeSelect.disabled = false;
    appointTypeSelect.value = "0"; // Reset to default value

    // Reset the location dropdown
    while (locationSelect.options.length > 0) {
        locationSelect.remove(0);
    }

    const locationDefaultOption = document.createElement('option');
    locationDefaultOption.textContent = "Selectează mai întâi tipul programării";
    locationDefaultOption.disabled = true;
    locationDefaultOption.selected = true;
    locationSelect.appendChild(locationDefaultOption);
    locationSelect.disabled = true;

    // Reset the doctor dropdown
    resetDoctorSelect();
    resetInterval()
    resetDate()

    // Reattach the event listener for appointment type
    appointTypeSelect.addEventListener('change', handleSelectionChange);
});

function handleSelectionChange() {
    const service = document.getElementById('service_id').value;
    const appointType = document.getElementById('appointment_type').value;
    const locationSelect = document.getElementById('location_id');

    // Reset the location dropdown
    while (locationSelect.options.length > 0) {
        locationSelect.remove(0);
    }

    // Reset the doctor dropdown
    resetDoctorSelect();
    resetInterval()
    resetDate()

    // Enable or disable locationSelect based on conditions
    if (!service || service === "0" || !appointType || appointType === "0") {
        locationSelect.disabled = true;
    } else {
        getLocation(service, locationSelect);
    }
}

function getLocation(service, locationSelect) {
    fetch("http://127.0.0.1:8000/api/v1/services/" + service + "?includeLocation=true")
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            // Access the nested locations array
            const locations = data.data.location;
            duration = data.data.duration

            if (locations != null) {
                const option = document.createElement('option');
                option.textContent = "Selectează locația";
                option.disabled = true;
                option.selected = true;
                locationSelect.appendChild(option);

                locations.forEach(location => {
                    const option = document.createElement('option');
                    option.value = location.id;
                    option.textContent = location.name;
                    locationSelect.appendChild(option);
                });
            }
            locationSelect.disabled = false;
        })
        .catch(error => {
            console.error('Error fetching locations:', error);
        });
}

/*
    ========================
    SELECT DOCTOR 
    ========================
*/

document.getElementById('location_id').addEventListener('change', handleDoctorChange);

function handleDoctorChange() {
    const location = document.getElementById('location_id').value;

    // Reset the doctor dropdown
    resetDoctorSelect();
    resetInterval()
    resetDate()

    if (!location || location === "0") {
        return;
    }

    // Reset the location dropdown
    while (document.getElementById('doctor_id').options.length > 0) {
        document.getElementById('doctor_id').remove(0);
    }

    fetch("http://127.0.0.1:8000/api/v1/location?id[eq]=" + location)
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        const locations = data.data;

        // Parse the starting and ending times from the JSON strings
        const startingTime = JSON.parse(locations[0].startingTime); // Assuming we're only interested in the first location
        const endingTime = JSON.parse(locations[0].endingTime);

        // Initialize timeInterval if it doesn't exist
        if (!timeInterval) {
            timeInterval = {};
        }

        // Loop through each day of the week to build the time interval for that day
        startingTime.forEach((start, index) => {
            const day = start.day;
            const shortDay = dayMapping[day];

            // If the start time and end time are valid, save them in timeInterval
            if (
                start.start_time !== "Selecteaza ora" &&
                endingTime[index].end_time !== "Selecteaza ora"
            ) {
                timeInterval[shortDay] = [
                    start.start_time,
                    endingTime[index].end_time
                ];
            }
        });

    })
    .catch(error => {
        console.error("Error fetching doctors:", error);
    });

    // Fetch doctors based on the selected location
    fetch("http://127.0.0.1:8000/api/v1/doctors?location_id[eq]=" + location)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const doctors = data.data; // Access the doctors array directly
            document.getElementById('doctor_id').disabled = false; // Enable the dropdown

            // Add a default "Select a doctor" option
            const defaultOption = document.createElement('option');
            defaultOption.textContent = "Selectează un doctor";
            defaultOption.disabled = true;
            defaultOption.selected = true;
            document.getElementById('doctor_id').appendChild(defaultOption);

            const anyDoctor = document.createElement('option');
            anyDoctor.textContent = "Orice doctor";
            anyDoctor.value = "0";
            document.getElementById('doctor_id').appendChild(anyDoctor);

            // Populate the dropdown with doctors
            doctors.forEach(doctor => {
                const option = document.createElement('option');
                option.value = doctor.id;
                option.textContent = doctor.name;
                document.getElementById('doctor_id').appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error fetching doctors:', error);
        });
}

/*
    ========================
    RESET DOCTOR SELECT 
    ========================
*/

function resetDoctorSelect() {
    const doctorSelect = document.getElementById('doctor_id');

    // Clear previous options
    while (doctorSelect.options.length > 0) {
        doctorSelect.remove(0);
    }

    // Add a default "No doctor selected" option
    const defaultOption = document.createElement('option');
    defaultOption.textContent = "Selectează mai întâi o locație";
    defaultOption.disabled = true;
    defaultOption.selected = true;
    doctorSelect.appendChild(defaultOption);

    doctorSelect.disabled = true; // Disable the dropdown
}

/*
    ========================
    GET APPOINTMENT INFO 
    ========================
*/

document.getElementById('doctor_id').addEventListener('change', handleDateChange);

var availableDates = []; // Ensure global variables
var unavailableDates = [];
var intervals = {};

// Fetch and process data
function handleDateChange() {
    const doctor = document.getElementById('doctor_id').value;
    const location = document.getElementById('location_id').value;
    const dateSelector = document.getElementById('date-selector-create');

    if (!doctor) {
        return;
    } else if(doctor === 0 || doctor === '0') {

        // HAVE TO CHECK FOR ALL DOCTORS THAT DO SELECTED SERVICE
        const today = new Date();
        const nextYear = new Date(today);
        nextYear.setFullYear(today.getFullYear() + 1);

        const formattedToday = today.toISOString().split('T')[0];
        const formattedDate = nextYear.toISOString().split('T')[0];

        resetInterval()
        resetDate()

        fetch("http://127.0.0.1:8000/api/v1/appointments?locationId[eq]=" + location + "&date[gte]=" + formattedToday + "&date[lte]=" + formattedDate)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                const appointments = data.data;

                appointments.forEach(appointment => {
                    const date = appointment.date;
                    const serviceId = appointment.serviceId;
                    const startTime = `${appointment.hour}:${appointment.minute.toString().padStart(2, '0')}`;
                    const serviceData = services[serviceId];
                    const duration = serviceData?.[0]?.duration || 0;
                    const price = serviceData?.[0]?.price || 0;

                    const [startHour, startMinute] = startTime.split(':').map(Number);
                    const totalMinutes = startHour * 60 + startMinute + duration;
                    const endHour = Math.floor(totalMinutes / 60);
                    const endMinute = totalMinutes % 60;
                    const endTime = `${endHour.toString().padStart(2, '0')}:${endMinute.toString().padStart(2, '0')}`;
                    const interval = `${startTime}-${endTime}`;

                    if (!servicesByDate[date]) {
                        servicesByDate[date] = {
                            serviceId: [],
                            duration: [],
                            price: [],
                            interval: []
                        };
                    }

                    servicesByDate[date].serviceId.push(serviceId);
                    servicesByDate[date].duration.push(duration);
                    servicesByDate[date].price.push(price);
                    servicesByDate[date].interval.push(interval);
                });

                for (const date in servicesByDate) {
                    const combinedData = servicesByDate[date].interval.map((interval, index) => ({
                        interval,
                        serviceId: servicesByDate[date].serviceId[index],
                        duration: servicesByDate[date].duration[index],
                        price: servicesByDate[date].price[index]
                    }));

                    combinedData.sort((a, b) => {
                        const [aStart] = a.interval.split('-');
                        const [bStart] = b.interval.split('-');
                        return aStart.localeCompare(bStart);
                    });

                    servicesByDate[date].serviceId = combinedData.map(item => item.serviceId);
                    servicesByDate[date].duration = combinedData.map(item => item.duration);
                    servicesByDate[date].price = combinedData.map(item => item.price);
                    servicesByDate[date].interval = combinedData.map(item => item.interval);
                }

                const result = findAvailableDatesAndIntervals(servicesByDate, duration, timeInterval);

                // Assign the result to global variables
                availableDates = result.availableDates;
                unavailableDates = result.unavailableDates;
                intervals = result.intervals;

                dateSelector.disabled = false;
                createDates(result.unavailableDates);
            })
            .catch(error => {
                console.error('Error fetching appointments:', error);
            });
    } else {
        const today = new Date();
        const nextYear = new Date(today);
        nextYear.setFullYear(today.getFullYear() + 1);

        const formattedToday = today.toISOString().split('T')[0];
        const formattedDate = nextYear.toISOString().split('T')[0];

        resetInterval()
        resetDate()

        fetch("http://127.0.0.1:8000/api/v1/appointments?doctorId[eq]=" + doctor + "&locationId[eq]=" + location + "&date[gte]=" + formattedToday + "&date[lte]=" + formattedDate)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                const appointments = data.data;

                appointments.forEach(appointment => {
                    const date = appointment.date;
                    const serviceId = appointment.serviceId;
                    const startTime = `${appointment.hour}:${appointment.minute.toString().padStart(2, '0')}`;
                    const serviceData = services[serviceId];
                    const duration = serviceData?.[0]?.duration || 0;
                    const price = serviceData?.[0]?.price || 0;

                    const [startHour, startMinute] = startTime.split(':').map(Number);
                    const totalMinutes = startHour * 60 + startMinute + duration;
                    const endHour = Math.floor(totalMinutes / 60);
                    const endMinute = totalMinutes % 60;
                    const endTime = `${endHour.toString().padStart(2, '0')}:${endMinute.toString().padStart(2, '0')}`;
                    const interval = `${startTime}-${endTime}`;

                    if (!servicesByDate[date]) {
                        servicesByDate[date] = {
                            serviceId: [],
                            duration: [],
                            price: [],
                            interval: []
                        };
                    }

                    servicesByDate[date].serviceId.push(serviceId);
                    servicesByDate[date].duration.push(duration);
                    servicesByDate[date].price.push(price);
                    servicesByDate[date].interval.push(interval);
                });

                for (const date in servicesByDate) {
                    const combinedData = servicesByDate[date].interval.map((interval, index) => ({
                        interval,
                        serviceId: servicesByDate[date].serviceId[index],
                        duration: servicesByDate[date].duration[index],
                        price: servicesByDate[date].price[index]
                    }));

                    combinedData.sort((a, b) => {
                        const [aStart] = a.interval.split('-');
                        const [bStart] = b.interval.split('-');
                        return aStart.localeCompare(bStart);
                    });

                    servicesByDate[date].serviceId = combinedData.map(item => item.serviceId);
                    servicesByDate[date].duration = combinedData.map(item => item.duration);
                    servicesByDate[date].price = combinedData.map(item => item.price);
                    servicesByDate[date].interval = combinedData.map(item => item.interval);
                }

                const result = findAvailableDatesAndIntervals(servicesByDate, duration, timeInterval);

                // Assign the result to global variables
                availableDates = result.availableDates;
                unavailableDates = result.unavailableDates;
                intervals = result.intervals;

                dateSelector.disabled = false;
                createDates();
            })
            .catch(error => {
                console.error('Error fetching appointments:', error);
            });
    }    
}


function createDates() {

    // Flatpickr configuration
    flatpickr("#date-selector-create", {
        dateFormat: "Y-m-d",
        enable: [
            function(date) {
                // Normalize the date to remove time zone differences
                const localDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000)
                    .toISOString()
                    .split('T')[0]; // Convert to YYYY-MM-DD

                // Check if the normalized date is in the unavailableDates array
                if (unavailableDates.includes(localDate)) return false;

                // Disable dates before today
                if (date.setHours(0, 0, 0, 0) < new Date().setHours(0, 0, 0, 0)) return false;

                // Disable days that are not working days based on `timeIntervals`
                const dayOfWeek = date.getDay(); // Get the day of the week (0 = Sunday, 1 = Monday, etc.)
                const dayNames = ["sun", "mon", "tue", "wed", "thu", "fri", "sat"];
                const dayString = dayNames[dayOfWeek]; // Get the string for the current day

                // Only allow days that are in timeIntervals
                return timeInterval[dayString] !== undefined;
            }
        ],
        minDate: new Date(), // Disable all previous dates (before today)
        maxDate: new Date(new Date().setFullYear(new Date().getFullYear() + 1)), // One year from today
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            // Normalize the date to match the format in unavailableDates
            const date = new Date(dayElem.dateObj.getTime() - dayElem.dateObj.getTimezoneOffset() * 60000)
                .toISOString()
                .split('T')[0];

            // Check if this day is in the `disabledDates` array
            const today = new Date().setHours(0, 0, 0, 0); // Start of today
            if (unavailableDates.includes(date)) {
                // Style for disabled dates
                dayElem.style.color = "#a1a1a1"; // Gray text
                dayElem.style.backgroundColor = "#f0f0f0"; // Light gray background
                dayElem.style.cursor = "not-allowed"; // Indicate disabled state
            } else if (dayElem.dateObj.setHours(0, 0, 0, 0) < today) {
                // Style for past dates
                dayElem.style.color = "#a1a1a1"; // Gray text
                dayElem.style.backgroundColor = "#f0f0f0"; // Light gray background
                dayElem.style.cursor = "not-allowed"; // Indicate disabled state
            } else {
                // Get the day of the week (0 = Sunday, 1 = Monday, etc.)
                const dayOfWeek = dayElem.dateObj.getDay();
                const dayNames = ["sun", "mon", "tue", "wed", "thu", "fri", "sat"];
                const dayString = dayNames[dayOfWeek]; // Get the string for the current day

                if (timeInterval[dayString] === undefined) {
                    // Non-working days
                    dayElem.style.color = "#a1a1a1"; // Gray text
                    dayElem.style.backgroundColor = "#f0f0f0"; // Light gray background
                    dayElem.style.cursor = "not-allowed"; // Indicate disabled state
                } else {
                    // Working days (within timeIntervals)
                    dayElem.style.backgroundColor = "#3b82f6"; // Blue background
                    dayElem.style.color = "white"; // White text
                    dayElem.style.borderRadius = "50%"; // Circle shape
                }
            }

            // Hide dates outside the current month
            if (dayElem.dateObj.getMonth() !== fp.currentMonth) {
                dayElem.style.visibility = "hidden"; // Hide the element
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            instance.redraw(); // Redraw to apply visibility changes
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            instance.redraw(); // Redraw to apply visibility changes
        }
    });


}

function findAvailableDatesAndIntervals(servicesByDate, duration, timeInterval) {
    const availableDates = [];
    const unavailableDates = [];
    const intervals = {};

    // Helper to convert "HH:mm" to total minutes
    const timeToMinutes = (time) => {
        const [hours, minutes] = time.split(':').map(Number);
        return hours * 60 + minutes;
    };

    // Helper to convert total minutes back to "HH:mm"
    const minutesToTime = (minutes) => {
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        return `${hours.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}`;
    };

    // Get the day of the week for a given date
    const getDayOfWeek = (date) => {
        const days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        return days[new Date(date).getDay()];
    };

    for (const date in servicesByDate) {
        const dayOfWeek = getDayOfWeek(date);

        // If no workday times are defined for this day, skip it
        if (!timeInterval[dayOfWeek]) {
            unavailableDates.push(date);
            continue;
        }

        const [workdayStart, workdayEnd] = timeInterval[dayOfWeek].map(timeToMinutes);

        const bookings = servicesByDate[date];
        const intervalsOnDate = bookings.interval
            .map(interval => {
                const [start, end] = interval.split('-');
                return [timeToMinutes(start), timeToMinutes(end)];
            })
            .sort((a, b) => a[0] - b[0]); // Sort by start time

        const gaps = [];
        let previousEnd = workdayStart;

        // Check gaps between bookings
        for (const [start, end] of intervalsOnDate) {
            if (start - previousEnd >= duration) {
                gaps.push([previousEnd, start]); // Add the gap
            }
            previousEnd = Math.max(previousEnd, end); // Update the end of the previous booking
        }

        // Check gap after last booking
        if (workdayEnd - previousEnd >= duration) {
            gaps.push([previousEnd, workdayEnd]);
        }

        // If there are valid gaps, store them
        if (gaps.length > 0) {
            availableDates.push(date);
            intervals[date] = gaps.map(([start, end]) => `${minutesToTime(start)}-${minutesToTime(end)}`);
        } else {
            unavailableDates.push(date);
        }
    }

    return { availableDates, unavailableDates, intervals };
}

/*
    ========================
    HANDLE TIME INTERVAL
    ========================
*/


document.getElementById('date-selector-create').addEventListener('change', handleTimeInterval);

function handleTimeInterval() {
    resetInterval()

    const date = this.value;

    // Check if the selected date is not in the available dates
    if (!availableDates.includes(date)) {        
        const dayAbb = getDayAbbreviation(date);

        // Get start and end times for the selected day
        const intervalStart = timeInterval[dayAbb]?.[0];
        const intervalEnd = timeInterval[dayAbb]?.[1];

        // Check if start and end times exist
        if (intervalStart && intervalEnd) {
            const timeOptions = generateTimeIntervals(intervalStart, intervalEnd, duration);

            // Populate the select element
            const selectElement = document.getElementById("time");
            selectElement.innerHTML = ""; // Clear previous options

            timeOptions.forEach(option => {
                const opt = document.createElement("option");
                opt.value = option;
                opt.textContent = option;
                selectElement.appendChild(opt);
            });

            selectElement.disabled = false; // Enable the select element
        } else {
            console.error("Time interval not found for the selected day.");
        }
    } else {
        if (intervals[date]) {
            const timeSlots = intervals[date]; // Array of time slots for the date
            const availableTimes = []; // Array to store generated time intervals
    
            // Process each time range
            timeSlots.forEach(range => {
                const [start, end] = range.split('-'); // Split range into start and end times
                let currentTime = convertToMinutes(start); // Convert start time to minutes
                const endTime = convertToMinutes(end); // Convert end time to minutes
    
                // Generate time intervals within the range
                while (currentTime + duration <= endTime) {
                    availableTimes.push(convertToTimeString(currentTime));
                    currentTime += 15;
                }
            });
    
            // Populate the select element
            const selectElement = document.getElementById("time");
            selectElement.innerHTML = ""; // Clear previous options
    
            availableTimes.forEach(option => {
                const opt = document.createElement("option");
                opt.value = option;
                opt.textContent = option;
                selectElement.appendChild(opt);
            });
    
            selectElement.disabled = false; // Enable the select element
        } else {
            console.error("No intervals found for the selected date.");
        }
    }
}
    
// Helper function to convert time string (e.g., "09:00") to minutes
function convertToMinutes(timeStr) {
    const [hours, minutes] = timeStr.split(':').map(Number);
    return hours * 60 + minutes;
}
    
// Helper function to convert minutes to time string (e.g., 540 -> "09:00")
function convertToTimeString(minutes) {
    const hours = Math.floor(minutes / 60).toString().padStart(2, '0');
    const mins = (minutes % 60).toString().padStart(2, '0');
    return `${hours}:${mins}`;
}
    

// Helper function to generate 15-minute intervals
function generateTimeIntervals(intervalStart, intervalEnd, duration) {
    const options = [];
    const [startHour, startMinute] = intervalStart.split(":").map(Number);
    const [endHour, endMinute] = intervalEnd.split(":").map(Number);

    const startTime = new Date();
    startTime.setHours(startHour, startMinute, 0, 0);

    const endTime = new Date();
    endTime.setHours(endHour, endMinute, 0, 0);

    // Calculate last valid time
    const lastValidTime = new Date(endTime - duration * 60 * 1000);

    let currentTime = new Date(startTime);

    // Generate intervals until the last valid time
    while (currentTime <= lastValidTime) {
        const hours = String(currentTime.getHours()).padStart(2, "0");
        const minutes = String(currentTime.getMinutes()).padStart(2, "0");
        options.push(`${hours}:${minutes}`);
        currentTime.setMinutes(currentTime.getMinutes() + 15);
    }

    return options;
}

function getDayAbbreviation(dateString) {
    // Parse the date string into a Date object
    const date = new Date(dateString);
    
    // Array of day abbreviations
    const days = ["sun", "mon", "tue", "wed", "thu", "fri", "sat"];
    
    // Get the day of the week as a number (0-6)
    const dayIndex = date.getDay();
    
    // Return the abbreviation
    return days[dayIndex];
}

function resetInterval() {
    const intervalTime = document.getElementById('time');

    // Clear previous options
    while (intervalTime.options.length > 0) {
        intervalTime.remove(0);
    }

    // Add a default "No doctor selected" option
    const defaultOption = document.createElement('option');
    defaultOption.textContent = "Selectează mai întâi data";
    defaultOption.disabled = true;
    defaultOption.selected = true;
    intervalTime.appendChild(defaultOption);

    intervalTime.disabled = true; // Disable the dropdown
}

function resetDate() {
    const dateTime = document.getElementById('date-selector-create');
    dateTime.value = ""
    dateTime.selected = false
    dateTime.disabled = true
    dateTime.placeholder = "Selectează mai întâi doctorul";
}