// Generate a random hsl color
function randColor() {
	let hue = Math.floor(Math.random() * (360 - 0 + 1) + 0);

	return `hsl(${hue}, 70%, 35%)`;
}

// Generate a random profile picture placeholder
export function randProfilePicture(str) {
	const canvas = document.createElement("canvas");
	canvas.width = 600;
	canvas.height = 600;
	const ctx = canvas.getContext("2d");
	ctx.fillStyle = randColor();
	ctx.fillRect(0, 0, canvas.width, canvas.height);

	//   text
	ctx.fillStyle = "#fff";
	ctx.textAlign = "center";
	ctx.textBaseline = "middle";
	ctx.font = "normal 280px Arial";
	ctx.textBaseline = "middle";
	ctx.fillText(str[0].toUpperCase(), canvas.width / 2, canvas.height / 2);

	// ctx.beginPath();
	// ctx.arc(canvas.width / 5, canvas.height / 3, 28, 0, 2 * Math.PI, false);
	// ctx.fillStyle = "#fff";
	// ctx.fill();
	// ctx.closePath();

	// ctx.beginPath();
	// ctx.arc(
	// 	canvas.width - canvas.width / 5,
	// 	canvas.height / 3,
	// 	28,
	// 	0,
	// 	2 * Math.PI,
	// 	false
	// );
	// ctx.fillStyle = "#fff";
	// ctx.fill();
	// ctx.closePath();

	// ctx.beginPath();
	// ctx.arc(
	// 	canvas.width / 2 + 80,
	// 	canvas.height / 2 + 40,
	// 	100,
	// 	1 * Math.PI,
	// 	0,
	// 	true
	// );
	// ctx.lineWidth = 28;
	// ctx.strokeStyle = "#fff";
	// ctx.stroke();
	// ctx.closePath();

	return canvas.toDataURL("image/png");
}
