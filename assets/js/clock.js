window.onload = () => {
  const clock = document.querySelector(".navbar__clock");

  const timeString = clock.innerText;
  const serverTime = Date.parse(Date(timeString));
  const clientTime = Date.now();
  const timeDiff = clientTime - serverTime;
  const timezoneDiff = new Date(serverTime).getTimezoneOffset() * 60000;

  if (clock) {
    setInterval(() => {
      const displayTime = new Date(Date.now() + timeDiff - timezoneDiff).toISOString().substr(11, 8);
      clock.innerText = `${displayTime}`;
    }, 1000);
  }
};
