window.onload = async () => {
  let response = await fetch("/functions/getDate.php").then(response => response.json());
  const clock = document.querySelector(".clock");
  if (clock) {
    setInterval(() => {
      response++;
      const date = new Date((response + 3600) * 1000).toISOString().substr(11, 8);
      clock.innerHTML = `${date}`;
    }, 1000);
  }
};
