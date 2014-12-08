<?php include('general/header.php') ?>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <canvas id="stage"></canvas>

        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="game-panel">
                <div class="row">
                  <div class="col-sm-9 text-center game-left">
                    <div class="top-panel text-left clearfix">
                      <div class="profile-image"></div>
                      <div class="health orbitron"><strong>HP: 30</strong></div>
                      <div class="score pull-right orbitron"><strong>Score: 30</strong></div>
                      <div class="timer">00:<span class="second">00</span></div>
                    </div>
                    <div class="question-panel orbitron text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere optio quaerat nostrum officia quo neque sed earum, cum ut. Sequi, quam. Distinctio architecto tempore repellendus nam accusamus fuga nihil qui.</div>
                    <div class="wrong-answer"></div>
                    <input type="text" id="boxanswer">
                    <div class="clearfix"></div>
                    <input type="button" class="answer orbitron" value="submit">
                  </div>
                  <div class="col-sm-3 mh80">
                    <h3 class="orbitron" style="margin-top: 30px;">Player List</h3>
                    <div id="enemy-panel">
                      <div class="enemy-list clearfix">
                        <div class="pic pull-left"></div>
                        <div class="pull-right">HP : <span>30</span></div>
                      </div>
                      <div class="enemy-list clearfix">
                        <div class="pic pull-left"></div>
                        <div class="pull-right">HP : <span>30</span></div>
                      </div>
                      <div class="enemy-list clearfix">
                        <div class="pic pull-left"></div>
                        <div class="pull-right">HP : <span>30</span></div>
                      </div>
                      <div class="enemy-list clearfix">
                        <div class="pic pull-left"></div>
                        <div class="pull-right">HP : <span>30</span></div>
                      </div>
                      <div class="enemy-list clearfix">
                        <div class="pic pull-left"></div>
                        <div class="pull-right">HP : <span>30</span></div>
                      </div>
                      <div class="enemy-list clearfix">
                        <div class="pic pull-left"></div>
                        <div class="pull-right">HP : <span>30</span></div>
                      </div>
                      <div class="enemy-list clearfix">
                        <div class="pic pull-left"></div>
                        <div class="pull-right">HP : <span>30</span></div>
                      </div>
                      <div class="enemy-list clearfix">
                        <div class="pic pull-left"></div>
                        <div class="pull-right">HP : <span>30</span></div>
                      </div>
                      <div class="enemy-list clearfix">
                        <div class="pic pull-left"></div>
                        <div class="pull-right">HP : <span>30</span></div>
                      </div>
                      <div class="enemy-list clearfix">
                        <div class="pic pull-left"></div>
                        <div class="pull-right">HP : <span>30</span></div>
                      </div>
                      <div class="enemy-list clearfix">
                        <div class="pic pull-left"></div>
                        <div class="pull-right">HP : <span>30</span></div>
                      </div>
                      <div class="enemy-list clearfix">
                        <div class="pic pull-left"></div>
                        <div class="pull-right">HP : <span>30</span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="game"></div>

        <?php   include('general/javascript.php') ?>

        <script>
            function dot(width, height, speed) {
              //Picks a random starting coordinate and speed within the bounds given
              this.x = Math.round(Math.random()*width);
              this.y = Math.round(Math.random()*height);
              this.speedX = Math.round(Math.random()*speed-speed/2);
              this.speedY = Math.random(Math.random()*speed-speed/2);
            }

            function dotGraph() {
              var maxDistance = 50;
              var numDots = 300;
              
              var canvas = document.getElementById("stage");
              var stage;
              var width = window.innerWidth;
              var height = window.innerHeight;
              var dots = [];
              var timer;
              
              var tick = function () {
                
                //Paints over old frame
                stage.fillStyle = "#2b699c";
                stage.rect(0, 0, width, height);
                stage.fill();
                
                stage.fillStyle = "#FFFFFF";
                var i=0;
                for (i=0; i<dots.length; i++) {
                  
                  //Move dot
                  dots[i].x+=dots[i].speedX;
                  dots[i].y+=dots[i].speedY;
                  
                  //Bounce dot off walls
                  if (dots[i].x<0) {
                    dots[i].x=0;
                    dots[i].speedX *= -1;
                  }
                  if (dots[i].x>width) {
                    dots[i].x=width;
                    dots[i].speedX *= -1;
                  }
                  if (dots[i].y<0) {
                    dots[i].y=0;
                    dots[i].speedY *= -1;
                  }
                  if (dots[i].y>height) {
                    dots[i].y=height;
                    dots[i].speedY *= -1;
                  }
                  
                  //Draw dot
                  stage.beginPath();
                  stage.arc(dots[i].x,dots[i].y,3,0,2*Math.PI);
                  stage.fill();
                }
                
                //Calculate distances between every dot
                var distances = [];
                for (i=0; i<dots.length; i++) {
                  for (var j=i+1; j<dots.length; j++) {
                    
                    //Add the line to the draw list if it's shorter than the specified max distance
                    var dist = Math.sqrt(Math.pow(dots[i].x-dots[j].x, 2) + Math.pow(dots[i].y-dots[j].y, 2));
                    if (dist <= maxDistance) distances.push([i, j, dist]);
                  }
                }

                //Draw the lines
                for (i=0; i<distances.length; i++) {
                  
                  //The farther the distance of the line, the less opaque it will be drawn
                  stage.strokeStyle = "rgba(255, 255, 255, " + (maxDistance-distances[i][2])/maxDistance + ")";
                  stage.beginPath();
                  stage.moveTo(dots[distances[i][0]].x, dots[distances[i][0]].y);
                  stage.lineTo(dots[distances[i][1]].x, dots[distances[i][1]].y);
                  stage.stroke();
                }
              };
              
              var resizeCanvas = function() {
                width = window.innerWidth;
                height = window.innerHeight;
                canvas.width=width;
                canvas.height=height;
                // console.log(width + ", " + height);
              };
              
              window.addEventListener("resize", function () {
                resizeCanvas();
              });
              
              //Maximize and set up canvas
              resizeCanvas();
              if (canvas.getContext) {
                stage = canvas.getContext("2d");
                
                //Create dots
                for (var i=0; i<numDots; i++) {
                  dots.push(new dot(width, height, 3));
                }
                
                //Set up timed function
                timer=setInterval(tick, 40);
              } else {
                alert("Canvas not supported.");
              }
            }

            var graph = new dotGraph();

            var game = new Phaser.Game(800, 600, Phaser.CANVAS, 'game', { preload: preload, create: create, update: update });
            // var game = new Phaser.Game(800, 600, Phaser.AUTO, 'phaser-example', { preload: preload, create: create, update: update });

            function preload() {

                game.load.image('spin1', '<?php echo base_url(); ?>assets/images/spinObj_01.png');
                //game.load.image('spin2', 'assets/spinObj_02.png');
                //game.load.image('spin3', 'assets/spinObj_03.png');
                game.load.image('spin4', '<?php echo base_url(); ?>assets/images/spinObj_04.png');

            }

            var renderTexture;
            var renderTexture2;
            var currentTexture;
            var outputSprite;
            var stuffContainer;
            var count = 0;

            function create() {
              // game.stage.backgroundColor = 0xffffff;
              // create two render textures.. these dynamic textures will be used to draw the scene into itself
              renderTexture = game.add.renderTexture(800, 600, 'texture1');
              renderTexture2 = game.add.renderTexture(800, 600, 'texture2');
              currentTexture = renderTexture;

              // create a new sprite that uses the render texture we created above
              outputSprite = game.add.sprite(400, 300, currentTexture);

              // align the sprite
              outputSprite.anchor.x = 0.5;
              outputSprite.anchor.y = 0.5;

              stuffContainer = game.add.group();
              stuffContainer.x = 800/2;
              stuffContainer.y = 600/2;

              // now create some items and randomly position them in the stuff container
              for (var i = 0; i < 20; i++)
              {
                var item = stuffContainer.create(Math.random() * 400 - 200, Math.random() * 400 - 200, game.rnd.pick(game.cache.getKeys(Phaser.Cache.IMAGE)));
                item.anchor.setTo(0.5, 0.5);
              }

              // used for spinning!
              count = 0;

            }

            function update() {

              stuffContainer.addAll('rotation', 0.1);

              count += 0.01;

              // swap the buffers..
              var temp = renderTexture;
              renderTexture = renderTexture2;
              renderTexture2 = temp;

              // set the new texture
              outputSprite.setTexture(renderTexture);

              // twist this up!
              stuffContainer.rotation -= 0.04
              outputSprite.scale.x = outputSprite.scale.y  = 1 + Math.sin(count) * 0.2;

              // render the stage to the texture
              // the true clears the texture before content is rendered
              renderTexture2.renderXY(game.stage, 0, 0, true);

            }

            var time = 5;
            intervalcanvas1 = setInterval(function(){
              if(time==0){
                clearInterval(intervalcanvas1);
                $('#game').hide();
                game.destroy();
              }
              time--;
            }, 1000);

            $('.answer').click(function(){
              // $('#game')
            });
        </script>
<?php include('general/footer.php') ?>
