const template = document.createElement('template')
template.innerHTML = `
	<div id="toggle" part="toggle" class="tkmm-toggle">
		<span part="toggle-bar"></span>
		<span part="toggle-bar"></span>
		<span part="toggle-bar"></span>
	</div>
    <div id="drawer">
		<div id="grab"></div>
	</div>
	<div id="overlay"></div>`

class SlideDrawer extends HTMLElement {
	constructor() {
		super()

		this.appendChild(template.content.cloneNode(true))
		this.overlay = this.querySelector('#overlay')
		this.grab = this.querySelector('#grab')
		this.drawer = this.querySelector('#drawer')
		this.toggles = this.querySelectorAll('.tkmm-toggle')

		// Grab and set all options
		this.right = this.hasAttribute('right')
		this.drawer_position = 'left';
		if (this.right) { this.drawer_position = 'right' }
		this.overlayOpacity = this.getAttribute('overlayOpacity') || .5
		this.overlay.style.background = `rgba(0,0,0,${this.overlayOpacity})`
		this.mobileWidth = this.getAttribute('mobileWidth') || '100%'
		this.mobileBreak = +this.getAttribute('mobileBreak') || 1200
		this.toggleDisplay = (window.innerWidth <= this.mobileBreak) ? 'block' : 'none'
		this.drawer.style.width = window.innerWidth <= this.mobileBreak ? this.mobileWidth : this.getAttribute('width') || '30%'
		this.drawer.style.backgroundColor = this.getAttribute('bg') || 'white'
		this.distance

		// set side specific classes and settings after right option is checked

		if (this.right) {
			this.drawer.style.left = window.innerWidth + 'px'
			this.grab.style.left = '-20px'
		} else {
			this.drawer.style.left = -this.drawer.offsetWidth + 'px'
			this.grab.style.right = '-20px'
		}
		this.resizeId

		// document.getElementById("menu-wrapper").style.display = "none";
	}


	// Add event listeners once web component mounts

	connectedCallback() {
		this.grab.addEventListener('mousedown', this.handleMouseDown, { passive: true })
		this.grab.addEventListener('touchstart', this.handleMouseDown, { passive: true })
		this.mobileBreak = this.getAttribute('mobileBreak');
		console.log(this.mobileBreak)
		window.addEventListener('resize', this.handleResize, { passive: true })
		this.toggles.forEach(toggle => {
			toggle.addEventListener('click', this.toggleDrawer, { passive: true })
		})
		this.updateVisibility();

		// Listen for changes to viewport width
		window.addEventListener('resize', () => this.updateVisibility());
		const items = Array.from(this.querySelectorAll('ul'))
		this.menuInit(items)

	}

	updateVisibility() {

		const windowWidth = window.innerWidth;
		console.log(windowWidth)
		if (windowWidth <= this.mobileBreak) {
			this.style.display = 'block';
		} else {
			this.style.display = 'none';
		}
	}



	// handles window resize

	handleResize = e => {
		this.drawer.classList.remove('animate')
		this.toggles.forEach(toggle => {
			window.innerWidth < this.mobileBreak ? toggle.style.display = 'flex' : toggle.style.display = 'none';
		})

		if (this.right) {
			if (this.drawer.classList.contains('open')) {
				this.drawer.style.left = window.innerWidth - this.drawer.offsetWidth + 'px'
			} else {
				this.drawer.style.left = window.innerWidth + 'px'
			}
		} else {
			if (this.drawer.classList.contains('open')) {
				this.drawer.style.left = 0
			} else {
				this.drawer.style.left = -this.drawer.offsetWidth + 'px'
			}
		}
	}

	// handles mouse down and drag on drawer
	handleMouseDown = e => {
		// console.log(e);
		this.drawer.classList.remove('animate')
		this.overlay.classList.add('on')

		// moves drawer with mouse position during drag

		// let count_thing = 0;
		const moveAt = e => {

			let pageX = e.type == 'touch' ? e.pageX : e.touches[0].clientX
			// count_thing++;
			// console.log('mousedown:' + count_thing)


			if (this.right) {
				if (pageX > window.innerWidth - this.drawer.offsetWidth && this.drawer.getBoundingClientRect().left <= window.innerWidth + 10) {
					this.drawer.style.left = pageX + 'px'
					// console.log(pageX)
				}
			} else {
				if (pageX < this.drawer.offsetWidth && this.drawer.getBoundingClientRect().right >= -10) {
					this.drawer.style.left = pageX - this.drawer.offsetWidth + 'px'
				}
			}
		}


		// checks current position of drawer converts to percentage completed and sets overlay opacity as such
		const overlayPercentage = e => {
			let pageX = e.type == 'touch' ? e.pageX : e.touches[0].clientX

			if (this.right) {
				let percentage = 1 - ((pageX - (window.innerWidth - this.drawer.offsetWidth)) / this.drawer.offsetWidth)
				if (pageX > window.innerWidth - this.drawer.offsetWidth) {
					this.overlay.style.opacity = percentage
				}
			} else {
				let percentage = pageX / this.drawer.offsetWidth
				if (pageX < this.drawer.offsetWidth) {
					this.overlay.style.opacity = percentage
				}
			}
		}

		moveAt(e)

		// calls both overlay and drawer move functions when mouse is moved
		const onMouseMove = e => {
			moveAt(e)
			overlayPercentage(e)
		}

		// event listener added on mouse down for dragging
		this.grab.addEventListener('mousemove', onMouseMove, { passive: true })
		this.grab.addEventListener('touchmove', onMouseMove, { passive: true })

		// on mouse up checks current drawer position for open/close threshold and kills mouse move listener
		this.grab.onmouseup = () => {
			this.grab.removeEventListener('mousemove', onMouseMove)
			this.grab.onmouseup = null
			if (this.right) {
				this.drawer.getBoundingClientRect().left < window.innerWidth - (this.drawer.offsetWidth / 4) ?
					this.open() : this.close()
			} else {
				this.drawer.getBoundingClientRect().right > this.drawer.offsetWidth / 4 ?
					this.open() : this.close()
			}
		}

		this.grab.ontouchend = () => {
			this.grab.removeEventListener('mousemove', onMouseMove)
			this.grab.onmouseup = null
			if (this.right) {
				this.drawer.getBoundingClientRect().left < window.innerWidth - (this.drawer.offsetWidth / 4) ?
					this.open() : this.close()
			} else {
				this.drawer.getBoundingClientRect().right > this.drawer.offsetWidth / 4 ?
					this.open() : this.close()
			}
		}

		// disables a built in function that isn't neccessary and can cause issues 
		this.grab.ondragstart = () => {
			return false
		}

	}

	// checks if drawer is open/closed when the menu button is clicked and toggles it
	toggleDrawer = () => {
		this.drawer.classList.add('animate')
		if (this.right) {
			this.drawer.getBoundingClientRect().right == window.innerWidth ?
				this.close() : this.open()
		} else {
			this.drawer.getBoundingClientRect().left == 0 ?
				this.close() : this.open()
		}
	}

	// adds all classes to open drawer and overlay, adds listener to overlay for closing with outside drawer click
	open = () => {
		document.body.style.overflow = 'hidden'
		this.drawer.classList.add('animate')
		this.drawer.classList.add('open')
		// this.right ? this.toggle.classList.add('rightOpen') : this.toggle.classList.add('leftOpen')
		// this.toggle.classList.add('open')
		this.overlay.classList.add('on', 'animate')
		this.right ?
			this.drawer.style.left = window.innerWidth - this.drawer.offsetWidth + 'px' : this.drawer.style.left = 0
		this.overlay.style.opacity = 1


		this.overlay.addEventListener('mousedown', this.handleOpenMouseDown, { passive: true })
		this.overlay.addEventListener('touchstart', this.handleOpenMouseDown, { passive: true })

	}

	// removes all classes to close drawer and overlay, sets drawer back to closed position
	close = () => {
		this.drawer.classList.add('animate')
		this.drawer.classList.remove('open')
		// this.right ? this.toggle.classList.remove('rightOpen') : this.toggle.classList.remove('leftOpen')
		// this.toggle.classList.remove('open')
		this.overlay.style.opacity = 0
		this.overlay.classList.remove('on', 'animate')
		this.right ?
			this.drawer.style.left = window.innerWidth + 'px' : this.drawer.style.left = -this.drawer.offsetWidth + 'px'
		document.body.style.overflow = 'initial'
	}

	// handles outside drawer click then kills listener
	handleOpenClick = e => {
		if (e.target == this.overlay) {
			let x1 = e.clientX, x2 = this.drawer.getBoundingClientRect().left
			// console.log(x2 - x1)
			this.close()
			this.overlay.removeEventListener('click', this.handleOpenClick)
		}
	}

	handleOpenMouseDown = e => {

		const handleOpenMove = e => {
			let pageX = e.type == 'touch' ? e.pageX : e.touches[0].clientX

			if (this.right) {
				if (pageX + this.distance > window.innerWidth - this.drawer.offsetWidth && this.drawer.getBoundingClientRect().left <= window.innerWidth + 10) {
					this.drawer.style.left = pageX + this.distance + 'px'
				}
			} else {
				if (pageX - this.distance < this.drawer.offsetWidth && this.drawer.getBoundingClientRect().right >= -10) {
					this.drawer.style.left = (pageX - this.distance) - this.drawer.offsetWidth + 'px'
				}
			}

		}

		const overlayPercentage = e => {
			let pageX = e.type == 'touch' ? e.pageX : e.touches[0].clientX

			if (this.right) {
				let percentage = 1 - (((pageX + this.distance) - (window.innerWidth - this.drawer.offsetWidth)) / this.drawer.offsetWidth)
				if ((pageX + this.distance) > window.innerWidth - this.drawer.offsetWidth) {
					this.overlay.style.opacity = percentage
				}
			} else {
				let percentage = (pageX - this.distance) / this.drawer.offsetWidth
				if ((pageX - this.distance) < this.drawer.offsetWidth) {
					this.overlay.style.opacity = percentage
				}
			}
		}

		const onMove = e => {
			handleOpenMove(e)
			overlayPercentage(e)
		}

		if (e.target == this.overlay) {
			let x1 = e.pageX, x2 = this.right ?
				this.drawer.getBoundingClientRect().left : this.drawer.offsetWidth
			this.distance = this.right ? x2 - x1 : x1 - x2
			this.drawer.classList.remove('animate')

			this.grab.addEventListener('mousemove', onMove, { passive: true })
			this.grab.addEventListener('touchmove', onMove, { passive: true })

			this.overlay.removeEventListener('mousedown', this.handleOpenMouseDown)
			this.overlay.removeEventListener('touchstart', this.handleOpenMouseDown)
		}

		document.onmouseup = () => {
			document.removeEventListener('mousemove', onMove)
			document.onmouseup = null
			this.close()
		}

		document.ontouchend = () => {
			document.removeEventListener('touchmove', onMove)
			document.ontouchend = null
			this.close()
		}

	}

	menuInit = items => {
		let drawer_position = this.drawer_position
		this.toggles.forEach(toggle => {
			window.innerWidth < this.mobileBreak ? toggle.style.display = 'flex' : toggle.style.display = 'none'
		})
		items.forEach(item => {
			item.style.width = this.drawer.offsetWidth + 'px'
			if (item.parentNode.tagName != "DIV") item.style.position = 'absolute'
			if (item.parentNode.tagName == "LI") {
				let dropdownArrow = '<span class="fas fa-angle-right"></span>'
				item.parentNode.classList.contains('menu-item-has-children')
					? item.parentNode.firstChild.innerHTML += dropdownArrow
					: null

				let back = document.createElement('li')
				let home = document.createElement('li')
				let title = document.createElement('li')
				home.innerHTML = '<span class="fas fa-angle-double-left"></span> Go Home' + home.innerHTML
				back.innerHTML = '<span class="fas fa-angle-left"></span> Back' + back.innerHTML
				item.style[drawer_position] = -item.offsetWidth + 'px'
				item.style.top = 0
				item.prepend(back)
				item.prepend(home)
				item.prepend(title)
				back.style.position = 'absolute'
				back.style.top = '80px'
				back.style.right = '20px'
				back.style.fontSize = '14px'
				home.style.position = 'absolute'
				home.style.top = '80px'
				home.style.left = '20px'
				home.style.fontSize = '14px'
				title.style.position = 'absolute'
				title.style.top = '30px'
				title.style.left = '50%'
				title.style.fontSize = '14px'
				title.style.fontWeight = 'bold'
				title.style.transform = 'translateX(-50%)'
				item.parentNode.firstChild.onclick = (e) => {
					e.preventDefault();

					// Set the transition properties before making the changes
					// item.parentNode.style.transition = "top 0.5s, bottom 0.5s, left 0.5s";
					item.style.transition = drawer_position + " 0.3s";

					item.style[drawer_position] = '0';
					item.parentNode.style.position = 'absolute';
					item.parentNode.style.top = '0';
					item.parentNode.style.bottom = '0';
					item.parentNode.style.left = '0';
					item.style.boxShadow = '0px 10px 15px -3px rgba(0, 0, 0, 0.3), 0px 14px 22px 2px rgba(0, 0, 0, 0.24), 0px 5px 20px 4px rgba(0, 0, 0, 0.22)';
					title.innerText = item.parentNode.firstChild.innerText.replace('>', '');

					// set next menu position relative to scroll action
					item.style.top = item.parentNode.getBoundingClientRect().top * -1 + 'px';

					// hide overflow of parent menu
					document.getElementById("menu-wrapper").style.overflow = 'hidden';
					// hide overflow of parent submenu
					item.parentNode.parentNode.style.overflow = 'hidden';

					item.parentNode.style[drawer_position] = '0';
					// console.log('clicked menu item', item);
					// console.log('clicked parentNode', item.parentNode);
					// console.log('parent menu item', item.parentNode.parentNode);
				}
				back.onclick = () => {
					item.parentNode.style.position = 'initial'
					item.style[drawer_position] = -item.offsetWidth + 'px'
					item.parentNode.style.top = 'initial'
					item.parentNode.style.bottom = 'initial'
					item.parentNode.style.left = 'initial'
					item.parentNode.style[drawer_position] = 'initial'
					item.parentNode.parentNode.style.overflow = 'overflow';
					// console.log('parent menu item', item.parentNode.parentNode.id)
					item.style.boxShadow = 'none';

					// if it's back to the top of the menu, re-enable overflow scrolling
					if (item.parentNode.parentNode.id == 'mobile_menu') {
						document.getElementById("menu-wrapper").style.overflowY = 'scroll';
					} else {

						// re-enable scrolling of previous sub-menu
						item.parentNode.parentNode.style.overflowY = 'scroll';
					}
				}
				home.onclick = () => {
					items.forEach(item => {
						if (item.parentNode.tagName == "LI") {
							item.parentNode.style.position = 'initial'
							item.style[drawer_position] = -item.offsetWidth + 'px'
							item.parentNode.style.top = 'initial'
							item.parentNode.style.bottom = 'initial'
							item.parentNode.style.left = 'initial'
							item.parentNode.style[drawer_position] = 'initial'
							item.style.boxShadow = 'none';
							// if it's back to the top of the menu, re-enable overflow scrolling
							if (item.parentNode.parentNode.id == 'mobile_menu') {
								document.getElementById("menu-wrapper").style.overflowY = 'scroll';
							} else {
								item.parentNode.parentNode.style.overflowY = 'scroll';
							}
						}
					})
				}
			}
		})
	}
}

window.customElements.define('slide-drawer', SlideDrawer)

// get the sticky element
const stickyElm = document.querySelector('header#masthead')
const drawer = document.querySelector('slide-drawer')


// if the header is set to sticky...
if (stickyElm.classList.contains('sticky_header')) {

	// calculate the height of the header items and position them accordingly
	let wp_admin_bar = document.querySelector('#wpadminbar');
	let top_bar = document.querySelector('.top-bar-content');
	let header = document.querySelector('#masthead');
	let wp_admin_bar_height = 0;
	let top_bar_height = 0;
	let header_height = 0;


	// if the admin bar exists, grab that height
	if (document.body.classList.contains('logged-in')) {
		// set the wp_admin_bar height static values (because it's not immediately available in the DOM to select and get the dynamic value -- it'll probably not change in height frequently anyway...)
		if (window.innerWidth > 784) {
			wp_admin_bar_height = 32;
		} else {
			wp_admin_bar_height = 46;
		}
	}

	// if the theme top bar exists, grab that height
	if (top_bar) {
		top_bar_height = document.querySelector('.top-bar-content').offsetHeight;
	}

	// the header always exists, grab that height
	header_height = document.querySelector('#masthead').offsetHeight;

	// position top bar
	// top bar is positioned fine, due to html margin-top from wp

	// position header
	header.style.position = "absolute";
	header.style.top = (wp_admin_bar_height + top_bar_height) + "px";


	// find half value
	document.addEventListener('scroll', function (e) {

		if (wp_admin_bar_height || top_bar_height) {

			// top bar is present, move header below it and snap it to the top of the browser after scrolling past the top bar content
			if (window.scrollY > top_bar_height) {
				header.style.position = "fixed";
				header.style.top = wp_admin_bar_height + "px";
			}

			if (window.scrollY < top_bar_height) {
				header.style.position = "absolute";
				header.style.top = (wp_admin_bar_height + top_bar_height) + "px";
			}

			// no top bar is present, behave normally
			if (window.scrollY > (header_height + top_bar_height) / 2) {
				stickyElm.classList.add('is-stuck');
				drawer.classList.add('is-stuck');
			}
			if (window.scrollY < (header_height + top_bar_height) / 4) {
				stickyElm.classList.remove('is-stuck');
				drawer.classList.remove('is-stuck');
			}

		} else {

			// no top bar is present, behave normally
			// console.log('window.scrollY', window.scrollY)
			if (window.scrollY > 1) {
				header.style.position = "fixed";
				header.style.top = wp_admin_bar_height + "px";
				stickyElm.classList.add('is-stuck');
			}
			if (window.scrollY < 2) {
				stickyElm.classList.remove('is-stuck');
				header.style.position = "absolute";
				header.style.top = (wp_admin_bar_height + top_bar_height) + "px";

			}
		}


	}, { passive: true });
}



jQuery(document).ready(function ($) {

	// sub-menu animations
	$('.navbar .dropdown').hover(function () {
		$(this).find('.dropdown-menu').first().stop().fadeIn(200); // use slideDown(300) for animation
	}, function () {
		// $(this).find('.dropdown-menu').first().stop().fadeOut(100) // use slideUp(300) for animation
		$(this).find('.dropdown-menu').first().hide() // use slideUp(300) for animation
	});

	// set height of all sub menu containers based on the height of the tallest container for overflow scroll if this is not set - and a parent menu item is taller than the subsequent sub menu, the sub menu will not cover the height of the parent

	// let menu_wrapper_height = document.querySelector('#menu-wrapper').scrollHeight;
	// let sub_menus = document.querySelectorAll('.sub-menu');

	// sub_menus.forEach(sub_menu => {
	// 	sub_menu.style.height = menu_wrapper_height + 'px';
	// });
	// console.log('Set submenu height to', menu_wrapper_height)

});

window.addEventListener('DOMContentLoaded', (event) => {
	const drawer = document.querySelector('#drawer');
	const menuWrapper = document.querySelector('#menu-wrapper');

	if (drawer && menuWrapper) {
		drawer.appendChild(menuWrapper);
	}
});
