let menuIds = ['m_home','m_roadmap'];

function setMenuItem(id) {
	menuIds.forEach((item, index) => {
		document.getElementById(item).className = "nav-link";
	});
	document.getElementById(id).className = "nav-link active";
	console.log("setting menu item");
}