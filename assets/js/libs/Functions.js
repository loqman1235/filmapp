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

	return canvas.toDataURL("image/png");
}

//  Create a filter
export function initFilter(
	[...dropdownItems],
	dropdownName,
	placeholderText,
	multiSelect = true
) {
	dropdownItems.forEach((item) => {
		if (!multiSelect) {
			if (item.classList.contains("checked")) {
				item.firstElementChild.classList.remove("fa-square");
				item.firstElementChild.classList.remove("fal");
				item.firstElementChild.classList.add("fas");
				item.firstElementChild.classList.add("fa-check-square");
			}
		}

		item.addEventListener("click", () => {
			if (!multiSelect) {
				dropdownItems.forEach((item) => {
					item.classList.remove("checked");
					item.firstElementChild.classList.remove("fas");
					item.firstElementChild.classList.add("fal");
					item.firstElementChild.classList.remove("fa-check-square");
					item.firstElementChild.classList.add("fa-square");
				});
				// Toggle active class of the dropdown checkboxes

				item.classList.toggle("checked");
				if (item.classList.contains("checked")) {
					item.firstElementChild.classList.remove("fa-square");
					item.firstElementChild.classList.remove("fal");
					item.firstElementChild.classList.add("fas");
					item.firstElementChild.classList.add("fa-check-square");
				} else {
					item.firstElementChild.classList.remove("fas");
					item.firstElementChild.classList.add("fal");
					item.firstElementChild.classList.remove("fa-check-square");
					item.firstElementChild.classList.add("fa-square");
				}
			} else {
				item.classList.toggle("checked");
				if (item.classList.contains("checked")) {
					item.firstElementChild.classList.remove("fa-square");
					item.firstElementChild.classList.remove("fal");
					item.firstElementChild.classList.add("fas");
					item.firstElementChild.classList.add("fa-check-square");
				} else {
					item.firstElementChild.classList.remove("fas");
					item.firstElementChild.classList.add("fal");
					item.firstElementChild.classList.remove("fa-check-square");
					item.firstElementChild.classList.add("fa-square");
				}
			}

			let checkedItems = [
				...new Set(document.querySelectorAll(`${dropdownName} .checked`)),
			];
			let checkItemsValues = [];
			let checkItemsText = [];
			item.parentElement.parentElement.firstElementChild.firstElementChild.innerText = `${checkedItems.length} ${placeholderText} selected`;
			checkedItems.forEach((checkedItem) => {
				checkItemsValues.push(
					isNaN(checkedItem.dataset.value)
						? checkedItem.dataset.value
						: parseInt(checkedItem.dataset.value)
				);
				checkItemsText.push(checkedItem.lastElementChild.textContent);
			});

			item.parentElement.parentElement.firstElementChild.firstElementChild.dataset.value =
				JSON.stringify(checkItemsValues);

			item.parentElement.parentElement.firstElementChild.firstElementChild.textContent =
				checkItemsText.length >= 2
					? checkItemsText.slice(0, 2).join(", ") + "..."
					: checkItemsText.join(", ");

			// If placeholder is empty
			if (
				item.parentElement.parentElement.firstElementChild.firstElementChild
					.textContent.length === 0
			) {
				item.parentElement.parentElement.firstElementChild.firstElementChild.textContent = `Select ${placeholderText}`;
			}
		});
	});
}
