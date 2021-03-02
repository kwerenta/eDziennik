window.onload = async () => {
  let response = await fetch("/functions/getDate.php").then(response => response.json());
  const clock = document.querySelector(".clock");
  if (clock) {
    setInterval(() => {
      response++;
      const time = new Date((response + 3600) * 1000).toISOString().substr(11, 8);
      clock.innerHTML = `${time}`;
    }, 1000);
  }
};
