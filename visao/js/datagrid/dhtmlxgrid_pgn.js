//v.1.5 build 71114

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
//PAGINAL OUTPUT IN DHTMLXGRID =======================================================
/**
*	@desc: enables paginal output of records in grid
*	@param: fl - true to enable paginal output
*	@param: pageSize - number of rows per page
*	@param: pagesInGrp - null to determine automatically (based on pages in portion [loaded at once or dynamicaly]). If dynamical loading enabled, permitted number of pages in group is limmited (pages in less than 2 portions)
*	@param: parentObj - object or id of element to append paging to
*	@param: showRecInfo - true to show Records Info
*	@param: recInfoParentObj - object or id of element to append Records Info block to (if no parent object for it specified, it will be append to paging block)
*	@type: public
*     @edition: Professional
*	@topic: 11
*/
dhtmlXGridObject.prototype.enablePaging = function(fl,pageSize,pagesInGrp,parentObj,showRecInfo,recInfoParentObj){
 		if(typeof(parentObj)=="string"){
			parentObj = document.getElementById(parentObj);
		}
		if(typeof(recInfoParentObj)=="string"){
			recInfoParentObj = document.getElementById(recInfoParentObj);
		}
		this.pagingOn = fl;
		this.showRecInfo = showRecInfo;
		this.rowsBufferOutSize = pageSize;
		this.pagingBlock = document.createElement("DIV");
		this.pagingBlock.className = "pagingBlock";
		this.recordInfoBlock = document.createElement("SPAN");
		this.recordInfoBlock.className = "recordsInfoBlock";
		if(parentObj)
			parentObj.appendChild(this.pagingBlock)
		if(recInfoParentObj)
			recInfoParentObj.appendChild(this.recordInfoBlock)
		this.currentPage = 1;
		this.pagesPrefix = this.pagesPrefix||"<font style='font-size:x-small;'>Resultados por p\u00e1gina: ";
		this.pagesDevider = "&nbsp;|&nbsp;"
		this._pagesInGroup=this.pagesInGroup = pagesInGrp;//will determ. automaticaly when first portion loaded if null
		this.recordsInfoStr = this.recordsInfoStr||"<font style='font-size:x-small;'>P\u00e1ginas <b>[from]-[to]</b> of [about]<b>[total]</b> </font>";
		this.noRecordStr = this.noRecordStr||"Nenhum encontrado";
		this.attachEvent("onClearAll",function(){
			this.pagesInGroup=this._pagesInGroup;
		})
}
/**
*	@desc: set new size of page in paging mode
*	@param: size - new page size
*	@type: public
*   @edition: Professional
*	@topic: 11
*/
dhtmlXGridObject.prototype.setPageSize = function(size){
	this.rowsBufferOutSize = size;
	this.changePage();
}

/**
*	@desc: creates paging block (available pages, navigation, inserts records info)
*	@type: private
*	@topic: 11
*/
dhtmlXGridObject.prototype.createPagingBlock = function(){ 
	this.pagingBlock.innerHTML = "";
	var self = this;
	var pagesNum = Math.ceil((this.limit||(this.rowsBuffer[0].length+this.rowsCol.length))/this.rowsBufferOutSize);
	if(pagesNum==0){
		this.createRecordsInfo();
		return false;
	}
	
	
	if(!this.pagesInGroup || this.pagesInGroup>(pagesNum*2-2)){
		this.pagesInGroup = pagesNum;
	}
	//show pages
	var startOfGroup = (this.currentPage - (this.currentPage-1)%this.pagesInGroup)||1
	var lastPage = startOfGroup+this.pagesInGroup - 1
	if(this.recordsNoMore){
		lastPage = Math.min(pagesNum,lastPage);
	}
	
	//prefix
	var prefObj = document.createElement("SPAN");
	prefObj.innerHTML = this.pagesPrefix;
	this.pagingBlock.appendChild(prefObj);
	//previous
	if(startOfGroup!=1){
		var pageMark = document.createElement("SPAN");
		pageMark.innerHTML = "&lt;&nbsp;";
		this.pagingBlock.appendChild(pageMark)
		pageMark.className = "pagingPage";
		pageMark.cp = startOfGroup-1;
		pageMark.onclick = function(){
			self.changePage(this.cp)
		}
	}
	//pages
	for(var i=startOfGroup;i<=lastPage;i++){
		var pageMark = document.createElement("SPAN");
		pageMark.innerHTML = i;
		
		this.pagingBlock.appendChild(pageMark)
		if(i!=lastPage || !this.recordsNoMore || lastPage!=pagesNum){
			var divider = document.createElement("SPAN");
			divider.innerHTML = this.pagesDevider;
			this.pagingBlock.appendChild(divider)

		}
		if(this.currentPage==i){
			pageMark.className = "pagingCurrentPage";
		}else{
			pageMark.className = "pagingPage";
			pageMark.cp = i;
			pageMark.onclick = function(){
				self.changePage(this.cp)
			}
		}
	}
	//next (more pages available)
	if(!this.recordsNoMore || lastPage!=pagesNum){
		var pageMark = document.createElement("SPAN");
		pageMark.innerHTML = "&gt;";
		this.pagingBlock.appendChild(pageMark)
		pageMark.className = "pagingPage";
		pageMark.cp = i;
		pageMark.onclick = function(){
			self.changePage(this.cp)
		}
	}
	if(this.showRecInfo){
		if(this.recordInfoBlock.parentNode==null){
			this.pagingBlock.appendChild(document.createTextNode("    "))
			this.pagingBlock.appendChild(this.recordInfoBlock)
		}
		this.createRecordsInfo();
	}
	this.createRecordsInfo();

	this.callEvent("onPaging",[pagesNum]);
}

/**
*	@desc: builds Record Info block based on existing data
*	@type: private
*	@topic: 11
*/
dhtmlXGridObject.prototype.createRecordsInfo = function(){
	if(this.showRecInfo){
		if(this.recordInfoBlock.parentNode==null){
			this.pagingBlock.appendChild(document.createTextNode("    "))
			this.pagingBlock.appendChild(this.recordInfoBlock)
		}
	}
	else{
		return false;
	}
	
	this.recordInfoBlock.innerHTML = "";
	var rowsNum = this.getRowsNum()
	if(rowsNum==0){
		var outStr = this.noRecordStr;
	}else{
		var from = ((this.currentPage-1)*this.rowsBufferOutSize)+1;
		var to = Math.min((this.currentPage*this.rowsBufferOutSize),rowsNum)
		var outStr = this.recordsInfoStr.replace(/\[from\]/,from);
			outStr = outStr.replace(/\[to\]/,to);
			outStr = outStr.replace(/\[total\]/,rowsNum);
		if(this.recordsNoMore){
			outStr = outStr.replace(/\[about\]/,"");
		}else{
			outStr = outStr.replace(/\[about\]/,"known ");
		}
	}
	this.recordInfoBlock.innerHTML = outStr;
	
}

/**
*	@desc: changes page to output (paginal output), populates grid with new set of records. When dynamical loading enabled, do not request page more than one portion far from already loaded
*	@param: pageNum - page number
*	@type: public
*     @edition: Professional
*	@topic: 11
*/
dhtmlXGridObject.prototype.changePage = function(pageNum){ 
	if(pageNum<1){
		return false;
	}
	//1.5
	if(!this.callEvent("onBeforePageChanged",[this.currentPage,pageNum])){
		return;
	}
	if(pageNum)
		this.currentPage = parseInt(pageNum);
	this.createPagingBlock();
	
	//clear grid page
	var totalRows = this.obj._rowslength();
	
	for(var i=0;i<totalRows;i++){
		var tmpPar = this.obj._rows(0).parentNode
        tmpPar.removeChild(this.obj._rows(0));
	}
	//populate page
	var startRowInd = this.currentPage*this.rowsBufferOutSize - this.rowsBufferOutSize
	for(var i=startRowInd;i<(parseInt(startRowInd)+parseInt(this.rowsBufferOutSize));i++){
		var row = this.getRowFromCollection(i);
		if(row){
			//row.style.backgroundColor = "pink";
         	if (row.style.display=='none'){
         		startRowInd++
         		continue;
     		}			
			this.obj.firstChild.appendChild(row)
		}else{//prevents loading incorrect page
			if(startRowInd==i){
				if (this._startXMLLoading){ 
					this._pgTo=pageNum;
					this._pgEvent=this.attachEvent("onXLE",function(){
						var tself=this;
						
						window.setTimeout(function(){
							tself.detachEvent(tself._pgEvent);
							tself.changePage(tself._pgTo);
						},1); 
					});
					return;
				}
				this.changePage(this.currentPage-1)
			}
			break;
		}
	}
	this.setSizes();
	//the page changing caused new XML request - wait till the end
	

		
			
	if (startRowInd<i)
		this.callEvent("onPageChanged",[this.currentPage,startRowInd,i-1]);
}
/**
*	@desc: gets row from rowsCol by specified index. If no records in collection - tries to add from buffer or from server.
*	@param: ind - index of row in collection
*	@returns: table row object
*	@type: private
*	@topic: 2,11
*/
dhtmlXGridObject.prototype.getRowFromCollection = function(ind){
	var row = this.rowsCol[ind];
	if(!row){
		//alert("Row Index in collection: "+ind+"\nCollection length: "+this.rowsCol.length+"\nBuffer length: "+this.rowsBuffer[0].length)
			this.addRowsFromBuffer()
		if(this.getRowsNum()>ind || ( !this._startXMLLoading && this.limit && this.limit > ind)){
			row = this.getRowFromCollection(ind)
		}
	}
	return row;
}

/**
*	@desc: sets string to show before pages output in paginal output, like "Result Page: "
*	@param: str - string to show
*	@type: public
*     @edition: Professional
*	@topic: 11
*/
dhtmlXGridObject.prototype.setPagePrefix = function(str){
	this.pagesPrefix = str;
}
/**
*	@desc: get string shown before pages output in paginal output
*	@returns: string
*	@type: public
*     @edition: Professional
*	@topic: 11
*/
dhtmlXGridObject.prototype.getPagePrefix = function(){
	return this.pagesPrefix;
}
/**
*	@desc: set template of Record Info block in paginal output
*	@param: str - string for template, like "Results <b>[from]-[to]</b> of [about]<b>[total]</b>"
*	@type: public
*     @edition: Professional
*	@topic: 11
*/
dhtmlXGridObject.prototype.setRecordsInfoTemplate = function(str){
	this.recordsInfoStr = str;
}
/**
*	@desc: get template of Record Info block in paginal output
*	@returns: string template, like "Results <b>[from]-[to]</b> of [about]<b>[total]</b>"
*	@type: public
*     @edition: Professional
*	@topic: 11
*/
dhtmlXGridObject.prototype.getRecordsInfoTemplate = function(){
	return this.recordsInfoStr;
}
/**
*	@desc: sets string to show in records info when no records in grid
*	@param: str - string to show
*	@type: public
*     @edition: Professional
*	@topic: 11
*/
dhtmlXGridObject.prototype.setNoRecordsString = function(str){
	this.noRecordStr = str;
}
/**
*	@desc: get string to show in records info when no records in grid
*	@returns: string
*	@type: public
*     @edition: Professional
*	@topic: 11
*/
dhtmlXGridObject.prototype.getNoRecordsString = function(){
	return this.noRecordStr;
}
/**
*	@desc:	enables/disables records info in paginal output
*	@param:	fl - true to enable/false to disable
*	@type: public
*     @edition: Professional
*	@topic: 11
*/
dhtmlXGridObject.prototype.enableRecordsInfo = function(fl){
	this.showRecInfo = fl;
}
/**
*	@desc: sets(moves) records info block to new parent element
*	@param: obj - new parent element
*	@type: public
*     @edition: Professional
*	@topic: 11
*/
dhtmlXGridObject.prototype.setRecordsInfoParent = function(obj){
	if(!obj)
		if(this.recordInfoBlock.parentNode)
			this.recordInfoBlock.parentNode.removeChild(this.recordInfoBlock)
	else
		obj.appendChild(this.recordInfoBlock);
}
/**
*	@desc: moves paging block to new parent element
*	@param: obj - new parent element
*	@type: public
*     @edition: Professional
*	@topic: 11
*/
dhtmlXGridObject.prototype.setPagingBlockParent = function(obj){
	obj.appendChild(this.pagingBlock);
}
/**
*	@desc: set event handler to handle page changing (paginal output)
*	@param: func - function to call
*	@type: public
*     @edition: Professional
*	@topic: 10,11
*/
dhtmlXGridObject.prototype.setOnPageChanged = function(func){
     this.attachEvent("onPageChanged",func);
}
/**
*	@desc: capture event of paging block creation
*	@param: func - function to call
*	@type: public
*     @edition: Professional
*	@topic: 10,11
*/
dhtmlXGridObject.prototype.setOnPaging = function(func){
     this.attachEvent("onPaging",func);
}


/**
*	@desc: configure paging with toolbar mode ( must be called BEFORE enablePagingWT )
*	@param: navButtons - enable/disable navigation buttons
*	@param: navLabel - enable/disable navigation label
*	@param: pageSelect - enable/disable page selector
*	@param: perPageSelect - enable/disable rows per  page selector
*	@param: labels - (array) - array of labels, default is [Records from,to,Page,rows per page]
*	@type: public
*     @edition: Professional
*/
dhtmlXGridObject.prototype.setPagingWTMode = function(navButtons,navLabel,pageSelect,perPageSelect,labels){
	this._WTDef=[navButtons,navLabel,pageSelect,perPageSelect];
	this._WTlabels=labels||["Results","Records from "," to ","Page ","rows per page"];
}

/**
*	@desc: enable paging and setup dhtmlxToolbar for displaying paging navigation (requires dhtmlXProtobar.js,dhtmlXToolbar.js,dhtmlXToolbar.css)
*	@param: fl - true to enable paginal output
*	@param: pageSize - number of rows per page
*	@param: pagesInGrp - null to determine automatically (based on pages in portion [loaded at once or dynamicaly]). If dynamical loading enabled, permitted number of pages in group is limmited (pages in less than 2 portions)
*	@param: parentObjId - Id of HTML container for toolbar, or toolbar object
*	@returns: toolbar object
*	@type: public
*     @edition: Professional    
*/
dhtmlXGridObject.prototype.enablePagingWT = function(fl,pageSize,pagesInGrp,parentObjId){
	if (!this._WTDef) this.setPagingWTMode(true,true,true,true);

	var self = this;
	this.enablePaging(fl,pageSize,pagesInGrp);
	//populate records info
	this.setOnPageChanged(function(page,startRowInd,lastRowInd){ 
		if (this._WTDef[2]){
			self.aToolBar.enableItem("right");
			self.aToolBar.enableItem("rightabs");
			self.aToolBar.enableItem("left");
			self.aToolBar.enableItem("leftabs");
			if(self.currentPage==self.totalPages){
				self.aToolBar.disableItem("right");
				self.aToolBar.disableItem("rightabs");
			}else{
				if(self.currentPage==1){
					self.aToolBar.disableItem("left");
					self.aToolBar.disableItem("leftabs");
				}
			}
		}
		if (this._WTDef[2]){
			var sButton = self.aToolBar.getItem("pages");
			sButton.setSelected(page.toString())
		}
		if (this._WTDef[1]){
			var iButton = self.aToolBar.getItem("results");
			iButton.setText(this._WTlabels[1]+(startRowInd+1)+this._WTlabels[2]+(lastRowInd+1));
			}
	});
	this.setOnPaging(function(pNum){
        if (this._WTDef[2]){
			var pButton = self.aToolBar.getItem("pages")
			pButton.clearOptions();
			for(var i=0;i<pNum;i++){
				pButton.addOption((i+1),this._WTlabels[3]+(i+1))
			}
		}
        if (this._WTDef[3]){
			var ppButton = self.aToolBar.getItem("perpagenum")
			ppButton.setSelected(self.rowsBufferOutSize.toString())
		}
		if (this._WTDef[1]){
			var iButton = self.aToolBar.getItem("results");
			iButton.setText(this._WTlabels[1]+(1)+this._WTlabels[2]+(Math.min(parseInt(self.rowsBufferOutSize),this.rowsCol.length)));
		}
		self.totalPages = pNum;
	});
	//init toolbar
    if (!parentObjId.setOnClickHandler)
		this.aToolBar=new dhtmlXToolbarObject(parentObjId,'100%',22,"Grid Output");
	else
		this.aToolBar=parentObjId;
		var f1=function(val){
			switch (this.id){
				case "leftabs":
					self.changePage(1);
					break;
				case "left":
					self.changePage(self.currentPage-1);
					break;
				case "rightabs":
				    self.changePage(self.totalPages);
					break;
				case "right":
					self.changePage(self.currentPage+1);
					break;
				case "perpagenum":
                    self.rowsBufferOutSize = val;
					self.changePage();
					break;
				case "pages":
					self.changePage(val);
					break;
			}
		};
		this.aToolBar.showBar();

		//add buttons
		if (this._WTDef[0]){
			this.aToolBar.addItem(new dhtmlXImageButtonObject(this.imgURL+'ar_left_abs.gif',18,18,f1,'leftabs','To First Page'))
			this.aToolBar.addItem(new dhtmlXImageButtonObject(this.imgURL+'ar_left.gif',18,18,f1,'left','Previous Page'))
		}
		if (this._WTDef[1])
			this.aToolBar.addItem(new dhtmlXImageTextButtonObject(this.imgURL+'results.gif',this._WTlabels[0],150,18,0,'results','Found Records'))
		if (this._WTDef[0]){
			this.aToolBar.addItem(new dhtmlXImageButtonObject(this.imgURL+'ar_right.gif',18,18,f1,'right','Next Page'))
			this.aToolBar.addItem(new dhtmlXImageButtonObject(this.imgURL+'ar_right_abs.gif',18,18,f1,'rightabs','To Last Page'))
		}
		if (this._WTDef[2])
			this.aToolBar.addItem(new dhtmlXSelectButtonObject("pages","null","null",f1,120,18,"toolbar_select"));
		if (this._WTDef[3])
			this.aToolBar.addItem(new dhtmlXSelectButtonObject("perpagenum","5,10,15,20,25,30","5"+this._WTlabels[4]+",10"+this._WTlabels[4]+",15"+this._WTlabels[4]+",20"+this._WTlabels[4]+",25"+this._WTlabels[4]+",30"+this._WTlabels[4]+"",f1,120,18,"toolbar_select"));

		//set buttons initial state
		this.aToolBar.disableItem("results");
		return this.aToolBar;
}
//(c)dhtmlx ltd. www.dhtmlx.com