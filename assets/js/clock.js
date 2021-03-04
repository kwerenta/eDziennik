window.onload = () => {
  const clock = document.querySelector(".clock");

  const timeString = clock.innerText;
  const hoursString = timeString.substr(0, 2);
  const minutesString = timeString.substr(3, 2);
  const secondsString = timeString.substr(6, 2);

  let time = new Date();
  time.setHours(hoursString);
  time.setMinutes(minutesString);
  time.setSeconds(secondsString);
  time = Math.floor(time / 1000);

  if (clock) {
    setInterval(() => {
      time++;
      const displayTime = new Date((time + 3600) * 1000).toISOString().substr(11, 8);
      clock.innerHTML = `${displayTime}`;
    }, 1000);
  }
};
