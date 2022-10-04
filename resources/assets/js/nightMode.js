window.nightMode = _ => {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) return;

    window.addEventListener('resize', (event) => {
        create()
    });

    let stars = []
    let canvas = document.createElement('CANVAS')
    let ctx = null

    class Star {
        constructor(canvasWidth, canvasHeight) {
            this.centerX = Math.random() * canvasWidth
            this.centerY = Math.random() * canvasHeight
            this.bigRadius = Math.random() * 7
            this.smallRadius = Math.random() * this.bigRadius/2
            this.radius = Math.abs(Math.floor(Math.random() * (this.bigRadius - this.smallRadius)) + this.smallRadius)
            this.growing = Math.random() * 2 > 1
            this.color = 'white'
        }

        draw(context) {
            context.beginPath();
            context.arc(this.centerX, this.centerY, this.radius, 0, 2 * Math.PI, false)
            context.fillStyle = this.color
            context.fill()
            context.lineWidth = 5
            context.strokeStyle = this.color
            context.stroke()
        }

        update() {
            if (this.growing) {
                this.radius += this.bigRadius * 0.03
                if (this.radius > this.bigRadius) {
                    this.radius = this.bigRadius
                    this.growing = false
                }
            } else {
                this.radius -= this.bigRadius * 0.03
                if (this.radius < this.smallRadius) {
                    this.radius = this.smallRadius
                    this.growing = true
                }
            }
        }
    }

    function create() {
        canvas.setAttribute("id", "stars");
        canvas.style.zIndex = '-1'
        canvas.style.position = 'absolute'
        canvas.style.left = '0px'
        canvas.style.top = '0px'
        canvas.style.width = '100%'
        canvas.minHeigth = '100%'
        canvas.width = 5000
        canvas.height = document.body.offsetHeight / document.body.offsetWidth * 5000
        document.body.appendChild(canvas)

        ctx = canvas.getContext('2d');
        const amountStars = document.body.offsetWidth * document.body.offsetHeight / 6000;
        for (let i = 0; i < amountStars; i++) {
            stars.push(new Star(canvas.width, canvas.height))
        }
        stars.forEach((star) => {
            star.draw(ctx)
        })
    }

    create()

    function update() {
            ctx.clearRect(0, 0, canvas.width, canvas.height)
            stars.forEach((star, index) => {
                star.update()
                star.draw(ctx)
            })
            window.requestAnimationFrame(update);
        }
    window.requestAnimationFrame(update);
}

