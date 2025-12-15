const weatherDiv = document.getElementById('weather');

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        position => {
            fetch('/condition/fetch', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .content
                },
                body: JSON.stringify({
                    lat: position.coords.latitude,
                    lon: position.coords.longitude
                })
            })
                .then(response => response.json())
                .then(data => renderWeatherData(data))
                .catch(error => console.error(error));
        },
        error => console.error(error)
    );
}

function renderWeatherData(data) {
    if (!data || !data.weather || !data.weather.length) return;

    const now = Math.floor(Date.now() / 1000);
    const isNight = now < data.sys.sunrise || now > data.sys.sunset;

    const weatherId = data.weather[0].id;
    const timeOfDay = isNight ? 'Night' : 'Day';

    const temperatureIcon = `${ASSETS.images}/temperature.png`;
    const humidityIcon = `${ASSETS.images}/humidity.png`;
    const windIcon = `${ASSETS.images}/wind.png`;

    let video;
    let icon;

    switch (true) {
        case weatherId >= 200 && weatherId <= 232:
            video = `${ASSETS.weather}/storm${timeOfDay}.mp4`;
            icon = `${ASSETS.images}/storm.png`;
            break;
        case weatherId >= 300 && weatherId <= 599:
            video = `${ASSETS.weather}/rain${timeOfDay}.mp4`;
            icon = `${ASSETS.images}/rain.png`;
            break;
        case weatherId >= 600 && weatherId <= 699:
            video = `${ASSETS.weather}/snow${timeOfDay}.mp4`;
            icon = `${ASSETS.images}/snow.png`;
            break;
        case weatherId >= 700 && weatherId <= 799:
            video = `${ASSETS.weather}/fog${timeOfDay}.mp4`;
            icon = `${ASSETS.images}/fog.png`;
            break;
        case weatherId === 800:
            video = `${ASSETS.weather}/clear${timeOfDay}.mp4`;
            icon = `${ASSETS.images}/clear${timeOfDay}.png`;
            break;
        default:
            video = `${ASSETS.weather}/clouds${timeOfDay}.mp4`;
            icon = `${ASSETS.images}/clouds${timeOfDay}.png`;
    }

    weatherDiv.innerHTML = `
        <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover rounded-3xl">
            <source src="${video}" type="video/mp4">
        </video>

        <div class="relative z-30 flex justify-between px-10 pt-8">
            <div class="flex items-center gap-2">
                <span class="text-4xl text-white">${data.name}</span>
                <img src="${icon}" class="size-16">
            </div>

            <div class="flex items-center gap-2">
                <span class="text-4xl text-white">${Math.round(data.main.temp)}°C</span>
                <img src="${temperatureIcon}" class="size-16">
            </div>

            <div class="flex items-center gap-2">
                <span class="text-4xl text-white">${data.main.humidity}%</span>
                <img src="${humidityIcon}" class="size-16">
            </div>

            <div class="flex items-center gap-2">
                <span class="text-4xl text-white">${data.wind.speed} m/s</span>
                <img src="${windIcon}" class="size-16">
            </div>
        </div>
    `;
}
