class FighterSelector{
    constructor(){
        this.fighterList = document.querySelectorAll("div.fighter-box");
    }

    init(){
        document.querySelector(".btn-primary").disabled=true;
        this._clickHandler();
        this._random(document.querySelector(".btn-secondary"));
        this._fight();
        this._addNew();
    }

    _addNew(){
        let btn = document.querySelector(".btn-dark");
        btn.addEventListener("click",(e)=>{
            e.preventDefault();
            location.replace("./newFighter.html");
        })
    }

    _refreshFighters(){
        this._rdy();
        let currentFighter = document.querySelectorAll(".featured-cat-fighter-image");
        currentFighter[0].setAttribute("style","none");
        currentFighter[1].setAttribute("style","none");
        document.getElementsByTagName("h2")[0].innerHTML = "Choose your cat"
        Array.from(this.fighterList).forEach(item =>{
            if(item.firstChild.nextSibling.src != currentFighter[0].src && item.firstChild.nextSibling.src != currentFighter[1].src){
                item.style.display = "block";
            }else if(item.firstChild.nextSibling.src == currentFighter[0].src){
                item.style.display = "none";
                this._setInfo(JSON.parse(item.dataset.info),0);
            }else{
                item.style.display ="none";
                this._setInfo(JSON.parse(item.dataset.info),1);
            }
        })
    }

    _clickHandler(){
        Array.from(this.fighterList).forEach(item=>{
            let fighterSide = item.parentNode.parentNode.parentNode.parentNode.parentNode.id;
            item.addEventListener("click", (e)=>{
                e.preventDefault();
                let fighterInfo = JSON.parse(item.dataset.info);
                let chosenOneImg = document.querySelectorAll(".featured-cat-fighter-image")
                if(fighterSide == "firstSide"){
                    chosenOneImg[0].src = item.childNodes[1].src;
                    this._setInfo(fighterInfo,0);
                    this._refreshFighters();
                }else{
                    chosenOneImg[1].src = item.childNodes[1].src;
                    this._setInfo(fighterInfo,1);
                    this._refreshFighters();
                }
            })
        })
    }

    _random(btn){
        btn.addEventListener("click",(e)=>{
            e.preventDefault();
            do{
                var rnd1 = Math.round(Math.random()*5);
                var rnd2 = Math.round(Math.random()*5);
            }while(rnd1==rnd2);

            let fighterArray = Array.from(this.fighterList);
            let chosenOneImg = document.querySelectorAll(".featured-cat-fighter-image")
            let fighterInfo1 = JSON.parse(fighterArray[rnd1].dataset.info);
            let fighterInfo2 = JSON.parse(fighterArray[rnd2].dataset.info);

            chosenOneImg[0].src = fighterArray[rnd1].firstChild.nextSibling.src;
            this._setInfo(fighterInfo1,0);
            chosenOneImg[1].src = fighterArray[rnd2].firstChild.nextSibling.src;
            this._setInfo(fighterInfo2,1);

            this._refreshFighters();
        })
    }

    _rdy(){
        let btn = document.querySelector(".btn-primary");
        if(document.querySelectorAll(".featured-cat-fighter-image")[0].src!="https://via.placeholder.com/300" && document.querySelectorAll(".featured-cat-fighter-image")[1].src!= "https://via.placeholder.com/300"){
            btn.disabled = false;
        }else{
            btn.disabled = true;
        }
    }

    _setInfo(fighter,side){
        let info = document.querySelectorAll(".cat-info");
        info[side].children[3].textContent = "wins: " + fighter["record"]["wins"] + " loss: " + fighter["record"]["loss"];
        info[side].children[2].textContent = fighter["catInfo"];
        info[side].children[1].textContent = fighter["age"];
        info[side].children[0].textContent = fighter["name"];
    }

    _fight(){
        let btn = document.querySelector(".btn-primary");
        btn.addEventListener("click",(e)=>{
            Array.from(this.fighterList).forEach(item=>{
                item.style.display = "none";
            })
            document.querySelector(".btn-secondary").disabled = true;
            this._countDown(this.fighterList);
            this._refreshFighters();
        })
    }

    _countDown(fighterList){
        let fOne;
        let fTwo;
        let contenders = document.querySelectorAll(".featured-cat-fighter-image");
        let contendersInfo = document.querySelectorAll(".cat-info");
        Array.from(this.fighterList).forEach(item=>{
            if(JSON.parse(item.dataset.info)["name"]==contendersInfo[0].children[0].innerHTML){
                fOne = JSON.parse(item.dataset.info);
            }
            if(JSON.parse(item.dataset.info)["name"]==contendersInfo[1].children[0].innerHTML){
                fTwo = JSON.parse(item.dataset.info);
            }
        })

        setTimeout(function(){document.getElementsByTagName("h2")[0].innerHTML="3";} ,1000);
        setTimeout(function(){document.getElementsByTagName("h2")[0].innerHTML="2";} ,2000);
        setTimeout(function(){document.getElementsByTagName("h2")[0].innerHTML="1";} ,3000);
        let result = this._simulateFight(fOne,fTwo);
        setTimeout(function(){
                contenders[result[0]].setAttribute("style","border:5px solid green");
                contenders[result[1]].setAttribute("style","border:5px solid red");
                document.getElementsByTagName("h2")[0].innerHTML = "winner is " + contendersInfo[result[0]].children[0].innerHTML;
                Array.from(fighterList).forEach(item =>{
                    if(item.style.display=="none"){
                        item.style.display=="none"
                    }else{
                        item.style.display = "block";
                    }
                })
                document.querySelector(".btn-secondary").disabled = false;
            }
            ,4000);
    }

    _simulateFight(fOne,fTwo){
        let fOnePercent = (fOne["record"]["wins"])/(fOne["record"]["wins"] + fOne["record"]["loss"]);
        let fTwoPercent = (fTwo["record"]["wins"])/(fTwo["record"]["wins"] + fTwo["record"]["loss"]);
        let limit = 0.49;
        let rng = Math.round((Math.random()*(100)))/100;
        if(fOnePercent>fTwoPercent){
            limit+= (fOnePercent-fTwoPercent<=0.1 ? 0.1 : 0.2);
        }else{
            limit-= (fTwoPercent-fOnePercent<=0.1 ? 0.1 : 0.2);
        }
        var result = (rng<=limit ? [0,1] : [1,0]);
        Array.from(this.fighterList).forEach(item=>{
            if(JSON.parse(item.dataset.info)["name"] == fOne["name"]){
                var newRecord1 = JSON.parse(item.dataset.info);
                if(result[0] == 0){
                    newRecord1["record"]["wins"]+=1;
                    item.setAttribute("data-info",JSON.stringify(newRecord1));
                }else{
                    newRecord1["record"]["loss"]+=1;
                    item.setAttribute("data-info",JSON.stringify(newRecord1));
                }
            }
            if(JSON.parse(item.dataset.info)["name"] == fTwo["name"]){
                var newRecord2 = JSON.parse(item.dataset.info);
                if(result[0] == 1){
                    newRecord2["record"]["wins"]+=1;
                    item.setAttribute("data-info",JSON.stringify(newRecord2));

                }else{
                    newRecord2["record"]["loss"]+=1;
                    item.setAttribute("data-info",JSON.stringify(newRecord2));
                }
            }
        })
        this._setInfo(fOne,0);
        this._setInfo(fTwo,1);
        return result;
    }
}

const FighterSelectorObj = new FighterSelector();
FighterSelectorObj.init();
