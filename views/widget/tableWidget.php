<script>
const createTable = function(arrayObject = [], alias = {}, custome = {}, style = {}, funch = null, unprint = 0, startfrom = 0){
    const AppLib = function(el) {
        var obj = {}
        if (typeof el == 'object') {
            obj.el = el;
        } else {
            obj.el = document.createElement(el);
        }
        obj.ch = [];
        obj.id = function (a) {
            this.el.id = a;
            globalThis[a] = {
                parent: this.el,
                el: globalThis.el(this.el),
                child: function (a) {
                    return this.parent.appendChild(a.get())
                }
            }
            return this;
        }
        obj.text = function (a) {
            this.el.className += ' disable-selection ';
            this.el.innerText = a;
            return this;
        }
        obj.html = function (a) {
            this.el.innerHTML = a;
            return this;
        }
        obj.name = function (a) {
            this.el.setAttribute('name', a);
            return this;
        }
        obj.href = function (a) {
            this.el.setAttribute('href', a);
            return this;
        }
        obj.val = function (a) {
            this.el.value = a;
            return this;
        }
        obj.css = function (a, b) {
            if (typeof a == "object") {
                var ky = Object.keys(a);
                ky.forEach(function (item) {
                    this.el.style[item] = a[item];
                }, this)
                return this;
            } else {
                this.el.style[a] = b;
                return this;
            }
        }
        obj.change = function (func) {
            this.el.addEventListener('change', func, false);
            return this;
        }
        obj.keydown = function (func) {
            this.el.addEventListener('keydown', func, false);
            return this;
        }
        obj.mouseover = function (func) {
            this.el.addEventListener('mouseover', func, false);
            return this;
        }
        obj.resize = function (func) {
            var gopy = this;
            window.addEventListener('resize', function (e) {
                width = e.target.outerWidth;
                height = e.target.outerHeight;
                var elm = {
                    el: gopy.el,
                    width: width,
                    height: height
                }
                setTimeout(function () {
                    func(elm);
                }, 100)
            }, gopy)
            return gopy;
        }
        obj.load = function (func,asr = 100) {
            var gopy = this;
            var width = window.outerWidth;
            var height = window.outerHeight;
            var elm = {
                el: gopy.el,
                width: width,
                height: height
            }
            setTimeout(function () {
                func(elm);
            }, asr)
            return gopy;
        }
        obj.mouseout = function (func) {
            this.el.addEventListener('mouseout', func, false);
            return this;
        }
        obj.keypress = function (func) {
            this.el.addEventListener('keypress', func, false);
            return this;
        }
        obj.click = function (func) {
            this.el.addEventListener('click', func, false);
            return this;
        }
        obj.submit = function (func) {
            this.el.addEventListener('submit', function (e) {
                el = e.path[0];

                el = new FormData(el);

                var object = {};
                el.forEach(function (value, key) {
                    object[key] = value;
                });
                var json = object;

                func(json)

                e.preventDefault();
            }, false);
            return this;
        }
        obj.keyup = function (func) {
            this.el.addEventListener('keyup', func, false);
            return this;
        }
        obj.size = function (a) {
            this.el.style.fontSize = a;
            return this;
        }
        obj.type = function (a) {
            this.el.setAttribute("type", a);
            return this;
        }
        obj.attr = function (a, d) {
            this.el.setAttribute(a, d);
            return this;
        }
        obj.get = function () {
            if (this.ch.length != 0) {
                this.ch.forEach(function (item) {
                    this.el.appendChild(item)
                }, this)
                return this.el;
            } else {
                return this.el;
            }
        }

        obj.child = function (a) {
            this.ch.push(a.get());
            return this;
        }


        obj.getChild = function (pop) {
            return {
                parent: this.get().children[pop],
                el: globalThis.el(this.get().children[pop]),
                child: function (a) {
                    return this.parent.appendChild(a.get())
                }
            }
        }

        obj.row = function (a) {
            var d = AppLib('DIV')
                .class('row')

            a.forEach(function (elm) {
                d.child(
                    AppLib('DIV').class(elm['class']).child(elm['content'])
                )
            }, d);
            this.ch.push(d.get());
            return this;
        }
        return obj;
    }
    var idbaru = Date.now();
    var tableBaru = AppLib('TABLE').id('table-'+idbaru)
    if(unprint == 1){
      tableBaru.css('width', '100%')
    }
    var cekCustome = Object.keys(custome).length;
    //headnametable
    tableBaru.attr('cellpadding', '8px')
    tableBaru.attr('cellspacing', 0)

    tableBaru.child(
      AppLib('THEAD').child(
        AppLib('TR').id('table-head-'+idbaru).css('border-bottom','1px solid #ddd')
      )
    )
    tableBaru.child(
      AppLib('TBODY')
      .id('table-body-'+idbaru)
    )
    arrayObject.forEach(function(a, i){
      var newTr = AppLib('TR').css('border-bottom','1px solid #ddd')
      Object.keys(a).forEach(function(g,j){
        var newTd = AppLib('td')
        .size('12pt')
        if(custome[g] != undefined){
          newTd.html(custome[g](a[g], a, newTd, newTr, startfrom, i))
        }else{
          newTd.text(a[g])
        }

        if(style[g] != undefined){
          newTd.css(style[g])
        }

        newTr.child(newTd)
      })
      globalThis['table-body-'+idbaru].child(newTr);
    })

    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    if(arrayObject.length > 0){
      if(Object.keys(alias).length == 0){
        Object.keys(arrayObject[0]).forEach(function(a,i){
          globalThis['table-head-'+idbaru].child(
            AppLib('TH').css(style[a]).text(capitalizeFirstLetter(a.replaceAll('_', ' '))).size('12pt')
          )
        })
      }else{
        Object.keys(arrayObject[0]).forEach(function(a,i){
          if(alias[a] != undefined){
            globalThis['table-head-'+idbaru].child(
              AppLib('TH').css(style[a]).text(capitalizeFirstLetter(alias[a])).size('12pt')
            )
          }else{
            globalThis['table-head-'+idbaru].child(
              AppLib('TH').css(style[a]).text(capitalizeFirstLetter(a.replaceAll('_', ' '))).size('12pt')
            )
          }
        })
      }
    }

    if(arrayObject.length == 0){
      tableBaru = AppLib('DIV')
      .css('text-align', 'center')
      .css('font-style', 'italic')
      .text('Data belum tersedia')
    }
    var paper = AppLib('DIV').load(function(a){
      setTimeout(function(){
        if(unprint == 0){
          printButton(a.el.innerHTML);
        }
      }, 1000)
    })
    .css('min-width','100%')
    .child(tableBaru)

    var scallerDiv = AppLib('DIV')
    .id('scaller').child(paper)
    if(funch != null){
      scallerDiv.load(function(e){
        setTimeout(function(){
          funch(e);
        },100)
      })
    }

    return scallerDiv;
  }
	const widgetTable = function(){
		if(arguments[0] != undefined){
			if(typeof arguments[0] == 'object' && Array.isArray(arguments[0]) === false){



				var data = arguments[0];
				data.hq = data.query;

				if(data.startfrom == undefined){
					data.startfrom = 0;
				}

				if(data.remember != undefined){
					if(data.remember == true){
						if(sessionStorage.getItem('pg'+location.href) == undefined){
							sessionStorage.setItem('pg'+location.href, data.startfrom)
						}else{
							data.startfrom = Number(sessionStorage.getItem('pg'+location.href))
						}
					}
				}
				
				if(data.id != undefined){
					if(data.dataFilter != undefined){
						sessionStorage.setItem('WidgetTableAsarId'+data.id, JSON.stringify(data.dataFilter));
					}
				}

				var dh = [];

				(function loadDataTable(data){


					const newLoader = div().class('lds-roller')
					.child(
						el('style').html(`
							.lds-roller {
							  display: inline-block;
							  position: absolute;
							  top: 50%;
							  right: 50%;
							  width: 80px;
							  height: 80px;
							}
							.lds-roller div {
							  animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
							  transform-origin: 40px 40px;
							}
							.lds-roller div:after {
							  content: " ";
							  display: block;
							  position: absolute;
							  width: 7px;
							  height: 7px;
							  border-radius: 50%;
							  background: #333;
							  margin: -4px 0 0 -4px;
							}
							.lds-roller div:nth-child(1) {
							  animation-delay: -0.036s;
							}
							.lds-roller div:nth-child(1):after {
							  top: 63px;
							  left: 63px;
							}
							.lds-roller div:nth-child(2) {
							  animation-delay: -0.072s;
							}
							.lds-roller div:nth-child(2):after {
							  top: 68px;
							  left: 56px;
							}
							.lds-roller div:nth-child(3) {
							  animation-delay: -0.108s;
							}
							.lds-roller div:nth-child(3):after {
							  top: 71px;
							  left: 48px;
							}
							.lds-roller div:nth-child(4) {
							  animation-delay: -0.144s;
							}
							.lds-roller div:nth-child(4):after {
							  top: 72px;
							  left: 40px;
							}
							.lds-roller div:nth-child(5) {
							  animation-delay: -0.18s;
							}
							.lds-roller div:nth-child(5):after {
							  top: 71px;
							  left: 32px;
							}
							.lds-roller div:nth-child(6) {
							  animation-delay: -0.216s;
							}
							.lds-roller div:nth-child(6):after {
							  top: 68px;
							  left: 24px;
							}
							.lds-roller div:nth-child(7) {
							  animation-delay: -0.252s;
							}
							.lds-roller div:nth-child(7):after {
							  top: 63px;
							  left: 17px;
							}
							.lds-roller div:nth-child(8) {
							  animation-delay: -0.288s;
							}
							.lds-roller div:nth-child(8):after {
							  top: 56px;
							  left: 12px;
							}
							@keyframes lds-roller {
							  0% {
							    transform: rotate(0deg);
							  }
							  100% {
							    transform: rotate(360deg);
							  }
							}
						`)
					)
					.child(
						div()
					)
					.child(
						div()
					)
					.child(div()).child(div()).child(div()).child(div()).child(div()).get()

					if(data.remember != undefined){
						if(data.remember == true){
							sessionStorage.setItem('pg'+location.href, data.startfrom)
						}
					}
					var ceos = 0;
					var dft = '';
					if(data.id != undefined){
						if(data.dataFilter != undefined){
							dft = sessionStorage.getItem('WidgetTableAsarId'+data.id);
						}
					}
					if(getNode('pagination') != undefined){
						if(data.dataFilter != undefined){
						console.log(JSON.stringify(getNode('pagination').parent.data.dataFilter))
						console.log(dft)
						if(JSON.stringify(getNode('pagination').parent.data.dataFilter) != dft){
	            				data.startfrom = 0;
								sessionStorage.setItem('pg'+location.href, 0);
								ceos = 1;
						}
					    }
					}
					if(data.id != undefined){
						if(data.dataFilter != undefined){
							sessionStorage.setItem('WidgetTableAsarId'+data.id, JSON.stringify(data.dataFilter));
						}
					}
					data.query = data.hq;
					if(data.query.includes('{limit}')){
						if(data.limit != undefined){
							data.query = data.query.replaceAll('{limit}', ` LIMIT ${data.startfrom}, ${data.limit}`);
						}else{
							data.query = data.query.replaceAll('{limit}', '');
						}
					}

					if(data.dataFilter != undefined){
						if(typeof data.dataFilter == 'object' && Array.isArray(data.dataFilter) == false){
							var ff = Object.keys(data.dataFilter);
							ff.forEach(function(vf){
								data.query = data.query.replaceAll('{'+vf+'}', data.dataFilter[vf]);
							})
						}
					}

					document.querySelector('#'+data.id).style.position = 'relative'
					document.querySelector('#'+data.id).appendChild(newLoader)

					AuditDevQuery(datalogin, data.query, function(arrData, countdata){
						setTimeout(function(){
							newLoader.remove()
						},200)
						data.countdata = countdata;
						if(data.remember != undefined){
							if(data.remember == true){
								if(Number(sessionStorage.getItem('pg'+location.href)) > countdata){
									sessionStorage.setItem('pg'+location.href, 0);
									data.startfrom = 0;
									loadDataTable(data);
									throw Error()
								}else{
								    if(data.ifNone != undefined){
								        data.ifNone(data);
								    }
								}
							}
						}


						var cust = {}
						var style = {}

						if(data.conf != undefined){
							Object.keys(data.conf).forEach(function(t){
								if(data.conf[t].style != undefined){
									style[t] = data.conf[t].style;
								}
								if(data.conf[t].custome != undefined){
									cust[t] = data.conf[t].custome;
								}
							})
						}

						if(data.id != undefined){

							if(data.customeHead != undefined){
								if(typeof data.customeHead == 'function'){
									data.customeHead(document.querySelector('#'+data.id),data,loadDataTable);
								}
							}

							if (document.querySelector('#'+data.id+' table') != undefined) {
								document.querySelector('#'+data.id+' table').remove();
							}

							if (document.querySelector('#scaller') != undefined) {
								document.querySelector('#scaller').remove();
							}

							if(document.querySelector('#'+data.id+' #pagination') != undefined){
								document.querySelector('#'+data.id).insertBefore(
									createTable(
						                // load data array
						                arrData,
						                // alias head title
						                {},
						                // modifikasi data
						                cust,
						                // style table content
						                style
						                , function(e){
						                }, 1, data.startfrom
					                ).get(),
					                document.querySelector('#'+data.id+' #pagination')
								)
							}else{
								document.getElementById(data.id).appendChild(
									createTable(
						                // load data array
						                arrData,
						                // alias head title
						                {},
						                // modifikasi data
						                cust,
						                // style table content
						                style
						                , function(e){
						                }, 1, data.startfrom
					                ).get()
				                )
							}
			                if(data.pagination != undefined){
				                if(data.pagination == true){
				                	if(document.querySelector('#'+data.id+' #pagination') == undefined){
				                		var sy = 0;
				                		if(data.remember != undefined){
											if(data.remember == true){
												sy = Number(sessionStorage.getItem('pg'+location.href)) / data.limit;
											}
										}
				                		(function callpagin(st = 0, data){
				                			var total = 0;
											if(data.limit != undefined){
												total = Math.ceil(data.countdata / data.limit);
											} 
				                			if(document.querySelector('#'+data.id+' #pagination') != undefined){
				                				document.querySelector('#'+data.id+' #pagination').remove();
				                			}
					                		document.querySelector('#'+data.id).appendChild(
					                			div()
					                			.addModule('paginFunc', callpagin)
					                			.addModule('data', data)
					                			.id("pagination")
					                			.css('margin-top', '10px')
					                			.load(function(l){
					                				var e = l.el;
					                				var f = 7;
					                				if(total < 7){
					                					f = total;
					                				}
				                					var h = total;
					                				if((f + st) > h){
					                					f = 7 - ((f + st) - (h))
					                				}
					                				e.appendChild(
				                						div()
				                						.addModule('loadDataTable', loadDataTable)
				                						.addModule('loadpagin', callpagin)
				                						.addModule('h', h)
				                						.css('display', 'inline-block')
				                						.css('padding', '5px 12px')
				                						.css('margin', '0 5px')
				                						.css('cursor', 'pointer')
				                						.css('user-select', 'none')
				                						.click(function(){
				                							if((st - 7) > 0 ){
				                								data.startfrom = (st - 7) * data.limit;
				                								this.loadpagin(st - 7,data)
				                								this.loadDataTable(data)
				                							}else{
				                								data.startfrom = 0;
				                								this.loadpagin(0,data)
				                								this.loadDataTable(data)
				                							}
				                						})
				                						.text('prev').get()
				                					)
					                				for (var i = st; i < f + st; i++) {
					                					e.appendChild(
					                						div()
				                							.addModule('loadDataTable', loadDataTable)
				                							.addModule('page', i)
				                							.id('p-g-d-'+((i)*data.limit))
				                							.class('w-p-g-d')
					                						.css('display', 'inline-block')
					                						.css('padding', '5px 12px')
					                						.css('margin', '0 5px')
					                						.css('border-radius', '5px')
					                						.css('cursor', 'pointer')
					                						.css('user-select', 'none')
					                						.click(function(){
					                							data.startfrom = this.page * data.limit;
					                							this.loadDataTable(data)
					                						})
					                						.text(i+1).get()
					                					)
					                				}
					                				e.appendChild(
				                						div()
				                						.addModule('loadDataTable', loadDataTable)
				                						.addModule('loadpagin', callpagin)
				                						.addModule('h', h)
				                						.css('display', 'inline-block')
				                						.css('padding', '5px 12px')
				                						.css('margin', '0 5px')
				                						.css('cursor', 'pointer')
				                						.css('user-select', 'none')
				                						.click(function(){
				                							if((st + 7) < this.h ){
				                								data.startfrom = (st + 7) * data.limit;
				                								this.loadpagin(st + 7,data)
				                								this.loadDataTable(data)
				                							}else{
				                								
				                							}
				                						})
				                						.text('next').get()
				                					)

					                				Array.from(document.querySelectorAll('.w-p-g-d')).forEach((pgd)=>{
							                			var actv = 'p-g-d-'+data.startfrom;
							                			if(pgd.id == actv){
							                				pgd.style.background = '#4c8bf5';
							                				pgd.style.color = 'white';
							                			}else{
							                				pgd.style.background = 'white';
							                				pgd.style.color = 'black';
							                			}
							                		})

					                			},0)
					                			.get()
					                		);
				                		})(sy,data)
				                	}else{
				                		console.log(ceos)
				                		if(ceos == 1){
				                			getNode('pagination').parent.data = data;
				                			getNode('pagination').parent.paginFunc(0,data)
				                		}else{
					                		Array.from(document.querySelectorAll('.w-p-g-d')).forEach((pgd)=>{
					                			var actv = 'p-g-d-'+data.startfrom;
					                			if(pgd.id == actv){
					                				pgd.style.background = '#4c8bf5';
					                				pgd.style.color = 'white';
					                			}else{
					                				pgd.style.background = 'white';
					                				pgd.style.color = 'black';
					                			}
					                		})
				                		}
				                	}
				                }
			                }
						}
					})
				})(data)


			}else{
				alert('config widgetTable not object')
			}
		}
	}
</script>