(function (w, method) {
  version: "1.0",
    (mE = {
      cache: "1",
      clm: [null, ""],
      Ncl: "No Callback found - ",
      req: [],
      latlng: true,
      ElcDV: [],
      search_input: [],
      eMK: [],
      eMKg: [],
      eMNo: 0,
      emMkrs: [],
      pickCtrol: [],
      mkr_url: "https://apis.mapmyindia.com/map_v3/1.png",
      load: "<span class='mmiLoad'></span>",
      search_result_data: [],
      logo: "https://apis.mapmyindia.com/map_v3/mmilogo.png",
      geoHas:
        window.location.protocol == "https:" || location.hostname == "localhost"
          ? 1
          : 0,
      gE: function (params) {
        if (!params.eloc || params.eloc.length != 6) {
          console.error("Please provide six digits eloc");
          return false;
        }
        if (params.map && "object" == typeof params.map) {
          var mO = params.map,
            mpId = mO.getContainer().id,
            mpE = mE.chkMap(params.map);
        } else if (params.hasOwnProperty("map"))
          console.error("Map object passed, but not a valid map object");
        if (params && params.access_token) mE.k = btoa(params.access_token);
        var rtn,
          u =
            mE.pth +
            "/map_v3/?e=" +
            btoa(params.eloc) +
            "&k=" +
            mE.k +
            "&a=" +
            mE.au,
          Elcmkr;
        this.jP(u, params.eloc, function (data) {
          if (!data) return false;
          var data1 = data;
          if ("object" == typeof mO && data1) {
            var n = "",
              ad = "";
            if (data1.name) n = "<b> " + data1.name + " </br>";
            if (data1.address) ad = data1.address;
            var poph =
              '<span class="mmi_heading" style="font-size:14px"> ' +
              n +
              " <b>&#9797; eLoc:  " +
              params.eloc +
              '</b></span><br><span class="text" style="color:#777"> ' +
              ad +
              ' </span><br><span class="large"><a href="https://eloc.me/' +
              params.eloc +
              '" target="_blanck">View on Move</a></span>';
            var elc = params.eloc;
            if (data1.latitude && data1.longitude)
              elc = data1.latitude + "," + data1.longitude;
            var icon_obj;
            if ("object" == typeof params.icon) {
              icon_obj = {
                url: params.icon.options.iconUrl,
                width: params.icon.options.iconSize[0]
                  ? params.icon.options.iconSize[0]
                  : 30,
                height: params.icon.options.iconSize[1]
                  ? params.icon.options.iconSize[1]
                  : 40,
              };
            } else {
              icon_obj = {
                url: params.icon,
                width: params.width ? params.width : 30,
                height: params.height ? params.height : 40,
              };
            }
            if ("object" == typeof mE.eMK[mpId] && params.preserve !== true) {
              mE.eMK[mpId] = [];
            }
            if ("function" == typeof mE.eMK[mpId]) mE.eMK[mpId] = [];
            var htm;
            if (params.popupHtml) {
              htm = params.popupHtml;
            } else {
              htm = poph;
            }
            var markerOptions = {
              map: mO,
              eloc: [elc],
              popupHtml: params.markerPopup !== false ? [htm] : "",
              icon: icon_obj,
            };
            Elcmkr = MapmyIndia.elocMarker(markerOptions);
            mE.eMK[mpId].push(Elcmkr);
            if (typeof params.click_callback == "function") {
              Elcmkr.addListener("click", function () {
                var rt = { eloc: params.eloc, data: data1 };
                params.click_callback(rt);
              });
            }
            if (params.fitbounds !== false)
              Elcmkr.fitbounds(
                params.fitboundOptions
                  ? params.fitboundOptions
                  : { padding: 50, maxZoom: 17 }
              );
          }
          if ("object" == typeof mO && params.infoDiv !== false) {
            var HT =
              '<div class="default_div" style="margin-right:10px;background: #fff;padding: 10px;border-radius: 10px;min-width:220px">' +
              poph +
              "</div>";
            if (mpE.type == "L") {
              if ("object" == typeof mE.ElcDV[mpId]) mE.ElcDV[mpId].remove();
              var CdV = "";
              if (params.divId) CdV = document.getElementById(params.divId);
              if (CdV) {
                CdV.innerHTML = HT;
                CdV.style.display = "inline";
              } else {
                mE.ElcDV[mpId] = L.control({ position: "topleft" });
                mE.ElcDV[mpId].onAdd = function () {
                  var div = L.DomUtil.create("div", "infoCls_" + mpId);
                  L.DomEvent.disableClickPropagation(div);
                  div.innerHTML = HT;
                  return div;
                };
                mE.ElcDV[mpId].addTo(mO);
              }
            } else if (map.type == "M") {
              if (mE.ElcDV[mpId] && mE.ElcDV[mpId].map)
                map.removeControl(mE.ElcDV[mpId]);
              mE.ElcDV[mpId] = MapmyIndia.addControl({
                map: map,
                html: HT,
                position: "top-left",
              });
            }
          }
          if (typeof params.callback == "function")
            setTimeout(function () {
              params.callback(data1);
            }, 1);
          rtn = data1;
        });
        if ("object" == typeof mO) {
          return {
            id: mpId,
            map: mO,
            data: rtn,
            marker: Elcmkr,
            preserve: params.preserve,
            setDivContent: function (h) {
              if ("object" == typeof mE.ElcDV[this.id]) {
                if (h)
                  document.getElementsByClassName(
                    "infoCls_" + this.id
                  )[0].innerHTML = h;
              }
            },
            remove: function () {
              if (this.preserve) {
                var dt = mE.eMK[mpId];
                if (dt) {
                  dt.forEach(function (x) {
                    if ("function" == typeof x.remove) x.remove();
                  });
                  mE.eMK[mpId] = [];
                }
              }
              if (this.id) {
                if (map.type == "L") {
                  if ("object" == typeof mE.ElcDV[this.id])
                    mE.ElcDV[this.id].remove();
                }
                if (map.type == "M") {
                  if (mE.ElcDV[mpId] && mE.ElcDV[mpId].map)
                    map.removeControl(mE.ElcDV[mpId]);
                }
                if ("object" == typeof this.marker) {
                  this.marker.remove();
                }
                this.data = "";
                this.id = "";
              }
            },
            setPopup: function (params) {
              if (params === undefined) return false;
              if (this.id) this.marker.setPopup(params);
            },
            fitbounds: function (params) {
              if (this.preserve) MapmyIndia.fitMarkers(mE.eMK[mpId]);
              else {
                if ("object" == typeof this.marker)
                  this.marker.fitbounds({
                    padding: params && params.padding ? params.padding : 50,
                  });
              }
            },
          };
        } else return { data: rtn };
      },
      cT: function (success_callback) {
        if (
          Math.floor(Date.now() / 1000) + parseInt(mE.exp) <
          Math.floor(Date.now() / 1000)
        ) {
          if (typeof success_callback == "function")
            return success_callback("token expired!.");
          return "token expired!.";
        }
      },
      sT: function (t) {
        if (t) {
          var ptk = atob(mE.k).split("@")[0];
          mE.k = btoa(ptk + "@" + t);
          return true;
        }
        return false;
      },
      tmout: "",
      sE: function (text, params, success_callback) {
        if ("function" == typeof params) success_callback = params;
        if (!text) {
          var msg = { error: "Provide HTML input or search string" };
          if (
            params &&
            !params.hasOwnProperty("click_callback") &&
            success_callback
          )
            success_callback(msg);
          else return msg;
        }
        if (params === undefined) params = {};
        if (params && params.access_token) mE.k = btoa(params.access_token);
        if (text) {
          if (!params.hasOwnProperty("click_callback") && success_callback) {
            params.click_callback = success_callback;
          }
          var search_result = "",
            sbtn = text;
          if (sbtn !== null) inputId = sbtn.id;
          else {
            console.error("search input not initialized before method call");
            return false;
          }
          if (
            mE.search_input.indexOf(inputId) != -1 &&
            document.querySelectorAll("#" + inputId).length > 1
          ) {
            console.error(
              "Please assign different Id for search input, already used Id:" +
                inputId
            );
            return false;
          }
          mE.search_input.push(inputId);
          var location = params.location
              ? params.location.lat
                ? [params.location.lat, params.location.lng]
                : params.location
              : "",
            pod = params.pod ? btoa(params.pod) : "",
            filter = params.filter ? btoa(params.filter) : "",
            region = params.region ? btoa(params.region) : "";
          if (inputId) {
            sbtn.setAttribute("autocomplete", "off");
            var sbtnTop = sbtn.offsetTop + sbtn.offsetHeight / 2 - 10,
              sbtnLeft = sbtn.offsetLeft + sbtn.offsetWidth - 26;
            var dvrgt,
              li_selected,
              inputFocus = [];
            sbtn.onblur = function () {
              var id = this.id,
                actEl = "";
              inputFocus[sbtn.id] = 0;
              setTimeout(function () {
                var sDv = mE.$("#mmi_search_" + id);
                if (sDv && !inputFocus[sbtn.id]) sDv.style.display = "none";
                var rcross = mE.$("#inputright" + id);
                if (rcross) {
                  rcross.style.display = "none";
                }
              }, 1000);
            };
            var focus = function (e) {
              window.setTimeout(function () {
                if (mE.$("#MMIul_" + sbtn.id) && sbtn.value) {
                  mE.$(".mmi_search_dv").display("none");
                  mE.$(".mmi_rtDv").display("none");
                  mE.$("#mmi_search_" + sbtn.id).display("inline");
                }
                inputFocus[sbtn.id] = 1;
                var rcross = mE.$("#inputright" + sbtn.id);
                var rdv = mE.$("#mmi_search_" + sbtn.id);
                if (rdv) {
                  if (rdv.offsetLeft != sbtn.offsetLeft)
                    rdv.style.left =
                      (params.left != undefined
                        ? parseInt(params.left)
                        : sbtn.offsetLeft) + "px";
                  var inputtop =
                    params.top != undefined
                      ? params.top
                      : sbtn.offsetHeight + sbtn.offsetTop + "px";
                  if (inputtop != sbtn.offsetTop) rdv.style.top = inputtop;
                  if (
                    !sbtn.value &&
                    params.geolocation !== false &&
                    mE.geoHas &&
                    e.type != "focus"
                  ) {
                    rdv.innerHTML =
                      '<ul class="mmi_s_ul MMIscroll" id="MMIul_' +
                      sbtn.id +
                      '" style="margin-bottom:-16px"><li id="li_' +
                      sbtn.id +
                      '"><div class="dtt disMMiclk"><div class="resultMmi_img MMicrloc" ></div><div class="result_cont disMMiclk"><div class="highligher-search disMMiclk" style="color:#2275d7;font-size:14px">Current Location</div></div></div></li></ul>';
                    rdv.style.display = "inline";
                    mE.$("#li_" + sbtn.id).onclick = function () {
                      mE.geo(function (p) {
                        if (p.coords) {
                          var clTxt = "Current Location";
                          sbtn.value = clTxt;
                          rdv.style.display = "none";
                          rcross.style.display = "inline";
                          var resp = [
                            {
                              placeName: clTxt,
                              latitude: p.coords.latitude,
                              longitude: p.coords.longitude,
                              eLoc:
                                p.coords.latitude + "," + p.coords.longitude,
                              accuracy: p.coords.accuracy,
                            },
                          ];
                          if (typeof success_callback == "function")
                            success_callback(resp);
                          else return resp;
                        } else {
                          alert("Location Permissions unavailable.");
                        }
                      });
                    };
                  }
                }
                if (rcross && sbtn.value) {
                  rcross.style.display =
                    params.clearButton == false ? "none" : "inline";
                  sbtnLeft = sbtn.offsetLeft + sbtn.offsetWidth - 26;
                  sbtnTop = sbtn.offsetTop + sbtn.offsetHeight / 2 - 11;
                  if (rcross.offsetLeft != sbtnLeft)
                    rcross.style.left = sbtnLeft + "px";
                  if (sbtnTop != rcross.offsetTop)
                    rcross.style.top = sbtnTop + "px";
                }
              }, 100);
            };
            sbtn.addEventListener("focus", function (e) {
              focus(e);
            });
            sbtn.onclick = function (e) {
              focus(e);
            };
            sbtn.onkeydown = function (evt) {
              if (this.id != inputId) inputId = this.id;
              evt = evt || window.event;
              key = evt.keyCode;
              var skipkey = [27, 9, 20, 16, 17, 92, 37, 39];
              if (skipkey.indexOf(key) != -1) return true;
              if (MapmyIndia.current_location && location === "") {
                if (MapmyIndia.current_location[0])
                  location = MapmyIndia.current_location;
              }
              if (location != params.location) params.location = location;
              if (key == 40 || key == 38 || key == 13) {
                if (mE.$("#MMIul_" + this.id)) {
                  var li_first = mE.$("#" + this.id + "_li0");
                  var selected_li = document.querySelector(
                    "ul#MMIul_" + this.id + ">li.active"
                  );
                  if (
                    selected_li &&
                    mE.$("#mmi_search_" + inputId).style.display == "inline"
                  ) {
                    var selected_num = selected_li.id.replace(
                      this.id + "_li",
                      ""
                    );
                    if (key == 13) {
                      var clicked_dtt =
                        mE.search_result_data[this.id][parseInt(selected_num)];
                      if (clicked_dtt) {
                        if (params.click_callback) {
                          params.click_callback(
                            mE.sE_return(sbtn, [clicked_dtt])
                          );
                          mE.$("#mmi_search_" + inputId).style.display = "none";
                        }
                      }
                      return false;
                    }
                    var new_num_select = parseInt(selected_num) + 1;
                    if (key == 38) {
                      new_num_select = parseInt(selected_num) - 1;
                    }
                    if (mE.search_result_data[this.id].length <= new_num_select)
                      return false;
                    selected_li.removeAttribute("class", "active");
                    var next = mE.$("#" + this.id + "_li" + new_num_select);
                    if (next) {
                      next.setAttribute("class", "active");
                      var resultdvHt = document.getElementById(
                        "MMIul_" + inputId
                      );
                      if (resultdvHt) {
                        var ht = resultdvHt.offsetHeight,
                          curScrlPos = next.offsetTop;
                        if (curScrlPos > ht - next.offsetHeight) {
                          resultdvHt.scrollTop =
                            curScrlPos - ht + next.offsetHeight + 20;
                        } else if (curScrlPos > 1) resultdvHt.scrollTop = 0;
                      }
                    }
                  } else {
                    if (li_first && key == 40)
                      li_first.setAttribute("class", "active");
                    else if (key == 13 && sbtn.value) {
                      if (dvrgt) dvrgt.innerHTML = mE.load;
                      var u =
                        mE.pth +
                        "/map_v3/?&tk=" +
                        (params.tokenizeAddress === true ? 1 : 0) +
                        "&hp=" +
                        (params.hyperLocal === true ? 1 : 0) +
                        "&re=" +
                        region +
                        "&t=1&c=" +
                        (params.category === false ? 0 : 1) +
                        "&q=" +
                        btoa(this.value) +
                        "&l=" +
                        btoa(location) +
                        "&p=" +
                        pod +
                        "&f=" +
                        filter +
                        "&k=" +
                        mE.k +
                        "&a=" +
                        mE.au;
                      mE.jP(
                        u,
                        1,
                        function (data) {
                          if (data && data.indexOf("error-") != -1) {
                            if (typeof success_callback == "function")
                              success_callback({ error: data });
                          } else
                            mE.sE_res_dv(sbtn, data, search_result, params);
                          if (dvrgt) dvrgt.innerHTML = "✕";
                          if (params.clearButton == false)
                            dvrgt.style.display = "none";
                        },
                        true
                      );
                    }
                  }
                }
                return false;
              }
              dvrgt = mE.$("#inputright" + inputId);
              if (mE.tmout) clearTimeout(mE.tmout);
              mE.tmout = setTimeout(function () {
                if (
                  sbtn.value.length >
                  (params.searchChars &&
                  params.searchChars >= 1 &&
                  params.searchChars < 10
                    ? params.searchChars - 1
                    : 2)
                ) {
                  if (
                    dvrgt &&
                    dvrgt.innerHTML == "✕" &&
                    params.clearButton !== false
                  ) {
                    dvrgt.innerHTML = mE.load;
                    dvrgt.style.display = "inline-block";
                  }
                  if (params.hasOwnProperty("token_callback")) {
                    params.token_callback(mE.cT());
                  }
                  var u =
                    mE.pth +
                    "/map_v3/?b=" +
                    (params.bridge === false ? 0 : 1) +
                    "&q=" +
                    mE._s(sbtn.value) +
                    "&hp=" +
                    (params.hyperLocal === true ? 1 : 0) +
                    "&re=" +
                    region +
                    "&tk=" +
                    (params.tokenizeAddress === true ? 1 : 0) +
                    "&l=" +
                    btoa(location) +
                    "&p=" +
                    pod +
                    "&f=" +
                    filter +
                    "&k=" +
                    mE.k +
                    "&a=" +
                    mE.au;
                  mE.jP(
                    u,
                    1,
                    function (data) {
                      if (dvrgt) dvrgt.innerHTML = "✕";
                      if (params.clearButton == false)
                        dvrgt.style.display = "none";
                      if (data && data.indexOf("error-") != -1) {
                        if (data == "auth") {
                          search_result.innerHTML =
                            "<center><br>Page Expired <span style='padding:8px 12px;border: 1px solid #ddd;cursor:pointer' onclick='window.location.reload();'>Reload</span></center>";
                          search_result.style.display = "inline";
                        } else search_result.innerHTML = "";
                        if (typeof success_callback == "function")
                          success_callback({ error: data });
                      } else
                        mE.sE_res_dv(
                          sbtn,
                          data,
                          search_result,
                          params,
                          success_callback
                        );
                    },
                    true
                  );
                }
              }, 20);
              if (sbtn.value.length <= 1) {
                if (dvrgt) dvrgt.style.display = "none";
                if (search_result) search_result.style.display = "none";
                setTimeout(function () {
                  if (params.blank_callback && sbtn.value.length < 1)
                    params.blank_callback(sbtn);
                }, 1000);
              }
            };
            if (sbtn && !search_result) {
              if (dvrgt && search_result) dvrgt.style.display = "inline-block";
              else {
                search_result = document.createElement("div");
                search_result.id = "mmi_search_" + inputId;
                if ("object" == typeof L)
                  L.DomEvent.disableScrollPropagation(search_result);
                search_result.className = "mmi_search_dv";
                var wdh = sbtn.offsetWidth - 3;
                if (params.width) wdh = params.width;
                var hgt = "";
                if (params.height)
                  hgt = ";height:auto;max-height:" + params.height + "px";
                search_result.style =
                  "display:none;width:" +
                  wdh +
                  "px;top:" +
                  (sbtn.offsetHeight + sbtn.offsetTop) +
                  "px;left:" +
                  sbtn.offsetLeft +
                  "px" +
                  hgt;
                var insertDv = sbtn;
                if (params.divId) insertDv = mE.$("#" + params.divId);
                insertDv.parentNode.insertBefore(
                  search_result,
                  insertDv.nextSibling
                );
                spn = document.createElement("span");
                spn.id = "inputright" + inputId;
                spn.innerHTML = "✕";
                spn.className = "mmi_rtDv";
                var xcss =
                  "display:none;font-size: 14px;width:20px;height:20px;text-align: center;vertical-align:middle;line-height:20px;box-sizing:inherit;color: #111;z-index: 99999  !important;position: absolute;z-index: 12;cursor: pointer;background: #fff;";
                spn.style =
                  xcss + "top:" + sbtnTop + "px;left:" + sbtnLeft + "px";
                sbtn.parentNode.insertBefore(spn, sbtn.nextSibling);
                var styl = document.createElement("style");
                var css =
                  ".mmi_search_dv{text-align: left;border: 1px solid #efecec;border-top: 1px solid #d6a8a8;background: #fff;border-radius:3px;font-family: arial;position: absolute;z-index: 9999;height: auto;max-height: 350px;overflow: hidden;padding-bottom: 15px;line-height: 14px;}.result_cont{width:calc(100% - 46px);display: inline-block;margin-left: 10px;padding-top: 5px}" +
                  ".mmi_match{font-size:18px !important;color:#000}.mmi_search_dv .highligher-search{padding-bottom:3px;width:85%;float:left;font-size:18px;line-height:18px;color:#6f6e6e;text-align: left}#pwrd{position:absolute;bottom:0;background:#fff;font-size: 13px;text-align:center;width: 100%;border-top: 1px solid #c0b2b2;font-stretch: condensed;font-weight: 800;color: #999;}" +
                  ".mmi_s_ul li{padding: 5px 10px 05px 2px;border-bottom: 1px solid #fbf2f2;}.mmi_s_ul li:hover,.mmi_s_ul li.active {background-color: #e0e2e6;cursor: pointer;}.mmi_s_ul li.active>div>div.resultMmi_img{background: #fff}.mmi_s_ul::-webkit-scrollbar {width: 8px; background: #fff;  }.mmi_s_ul::-webkit-scrollbar-thumb {background: #ccc;border-right:1px solid #fff }" +
                  ".result_cont .madd {width:85%;line-height:14px;margin: 19px 0 3px 0;color:#888;font-size: 12px;text-align: left;}.MMIscroll::-webkit-scrollbar {width: 8px; background: #fff;  }.MMIscroll::-webkit-scrollbar-thumb {background: #ccc;border-right:1px solid #fff }" +
                  ".resultMmi_img {width: 30px;height: 30px;text-align: center;background-color: #efefef;border-radius: 50%;float: left;}.resultMmi_img img {margin-top: 9px;display: inline-block;}" +
                  ".mmi_s_ul {height: calc(100% - 2px);max-height: 340px;overflow-y: auto;list-style: none;padding: 0;margin-top:2px;margin-bottom:10px;background: #fff;-webkit-overflow-scrolling:touch;}" +
                  ".mmiLoad{font-size:11px;display:inline-block;margin:2px 0;border-radius: 50%;border-top: 3px solid #555;width: 72%;height:72%;-webkit-animation: mmi_spin 2s linear infinite;animation: mmi_spin 2s linear infinite;}@keyframes mmi_spin {  0% { transform: rotate(0deg); }  100% { transform: rotate(360deg); }}" +
                  ".mmiDis{float:right;font-style: oblique;font-size:12px;margin-right: -9;font-stretch: extra-expanded;text-align:right}" +
                  ".mmi_heading b{font-size:12px} .disMMiclk{pointer-events:none} .MMicrloc{box-sizing: initial;background: #3A78E7;width: 10px;height: 10px;margin: 7px 0 0 10px;border:3px solid #98c3dc;}";
                styl.innerHTML = css;
                search_result.after(styl);
                var xbtn = mE.$("#inputright" + inputId);
                if (xbtn) {
                  xbtn.onclick = function () {
                    sbtn.value = "";
                    sbtn.focus();
                    this.style.display = "none";
                    if (search_result) search_result.style.display = "none";
                    if (params.blank_callback) {
                      params.blank_callback(sbtn);
                    }
                  };
                }
              }
            }
            var rtn = {
              input: sbtn,
              dvrgt: mE.$("#inputright" + inputId),
              params: params,
              textSearch: function () {
                if (this.input && this.input.value) {
                  var dvrgt = this.dvrgt;
                  if (dvrgt) {
                    dvrgt.innerHTML = mE.load;
                    dvrgt.style.display = "block";
                  }
                  var u =
                    mE.pth +
                    "/map_v3/?&tk=" +
                    (params.tokenizeAddress === true ? 1 : 0) +
                    "&hp=" +
                    (params.hyperLocal === true ? 1 : 0) +
                    "&re=" +
                    region +
                    "&t=1&c=" +
                    (params.category === false ? 0 : 1) +
                    "&q=" +
                    mE._s(this.input.value) +
                    "&l=" +
                    btoa(location) +
                    "&p=" +
                    pod +
                    "&f=" +
                    filter +
                    "&k=" +
                    mE.k +
                    "&a=" +
                    mE.au;
                  mE.jP(
                    u,
                    1,
                    function (data) {
                      if (dvrgt) dvrgt.innerHTML = "X";
                      if (data && data.indexOf("error-") != -1) {
                        if (typeof success_callback == "function")
                          success_callback({ error: data });
                      } else mE.sE_res_dv(sbtn, data, search_result, params);
                    },
                    true
                  );
                }
              },
            };
            return rtn;
          } else {
            if (text) {
              var resp = [],
                async = params.async && success_callback ? true : false,
                g = params.geo ? 1 : 0;
              var u =
                mE.pth +
                "/map_v3/?b=" +
                (params.bridge ? 1 : 0) +
                "&q=" +
                mE._s(text) +
                "&hp=" +
                (params.hyperLocal === true ? 1 : 0) +
                "&re=" +
                region +
                "&l=" +
                btoa(location) +
                "&p=" +
                pod +
                "&f=" +
                filter +
                "&k=" +
                mE.k +
                "&a=" +
                mE.au +
                "&geo=" +
                g;
              mE.jP(
                u,
                1,
                function (data) {
                  if (
                    data &&
                    "string" == typeof data &&
                    data.indexOf("error-") != -1
                  )
                    resp = { error: data };
                  else resp = mE.sE_return("", data);
                  if (typeof success_callback == "function" && async)
                    success_callback(resp);
                },
                async
              );
              if (!async) {
                if (typeof success_callback == "function")
                  success_callback(resp);
                else return resp;
              }
            }
          }
        }
      },
      sE_res_dv: function (
        input,
        data,
        search_result,
        params,
        success_callback
      ) {
        if (data) {
          var list = [];
          var ht = "";
          if (params.height) ht = "max-height:" + (params.height - 30) + "px";
          var data_location = data,
            ul_str =
              '<ul class="mmi_s_ul" id="MMIul_' +
              input.id +
              '" style="' +
              ht +
              '">';
          var search_data = data_location;
          mE.search_result_data[input.id] = search_data;
          for (var i = 0; i < search_data.length; i++) {
            var img =
              "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAw0HJxLY+ISRAAAA5ElEQVQY0yXBPUoDYRSG0ee93zhDiOgUAYtAMDaKhQuwsbTRHZhliauwM03AzhT2IqTR+AMG9NNohqiZzFwLz1GHmpzZjg61SeoTLsvrUEFokPG7qx5dUgLrbIfvn4dAaEFTJ+poyR0vWlOD9sqtzUxoQ22cEWd+yhWuXFvCHE8JyKetLyv9DUeeQQK8U5BpLx55oQPEggkkjkcbsc8qx+BCPPvYsYBVPqTgn7NkGIo5ISHBp5bTBcC48b6XAXsFrPIBYwwR/YI5PGEgMixyrg8t6Kf3NQ4E+KSJIFIrMqhr8Qj8AUtLWbCKQJBeAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTAzLTEzVDA3OjM5OjEzKzAwOjAw5GLOegAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wMy0xM1QwNzozOToxMyswMDowMJU/dsYAAAAASUVORK5CYII=";
            var pname = search_data[i].placeName,
              plat = search_data[i].latitude,
              plng = search_data[i].longitude,
              paddr = search_data[i].placeAddress,
              catcode = search_data[i].keywords,
              elc = search_data[i].eLoc,
              sugg = search_data[i].suggester,
              altname = search_data[i].alternateName;
            if (pname && pname == pname.toUpperCase()) pname = mE.ucw(pname);
            if (!search_data[i]) continue;
            if (sugg == "alternateName") {
              var atl_arr = altname.split(",");
              for (var k = 0; k < atl_arr.length; k++) {
                if (
                  atl_arr[k]
                    .toLowerCase()
                    .indexOf(input.value.toLowerCase()) !== -1
                ) {
                  paddr = "(" + pname + ")<br>" + paddr;
                  pname = atl_arr[k];
                  break;
                }
              }
            }
            var keyword = search_data[i].keyword;
            var img_bg = "",
              img_css = "",
              img_size = "14px";
            if (keyword) {
              var mid = search_data[i].identifier,
                loc = search_data[i].location,
                paddr = "";
              pname = keyword + " " + mid + " " + loc;
              catcode = ["search"];
              img_size = "18px";
              img_bg = "background:#3A78E7";
              img_css = "margin-top:6px";
            }
            if (catcode) {
              if (catcode.length >= 1) {
                var cat_img = mE.catcode(catcode[0]);
                if (cat_img) img = cat_img;
              }
              pname = pname.replace(
                new RegExp(
                  "(" + input.value.replace(/[\/\\#,+$~%.'"*?<>{}]/g, "") + ")",
                  "gi"
                ),
                '<span class="mmi_match">$1</span>'
              );
            }
            list.push([pname, plat, plng, paddr]);
            var elc_dv = "";
            if (params.eloc)
              elc_dv =
                '<span class="highligher-search">eLoc:' + elc + "</span>";
            var disDv = "",
              lat = params.location[0],
              lng = params.location[1];
            if (params.distance !== false && lat && lng && plat && plng) {
              var ds = mE.ds(lat, lng, plat, plng);
              if (ds) {
                ds = Math.round(ds * 10) / 10;
                disDv =
                  '<div class="mmiDis">' +
                  ds +
                  "<br> km" +
                  (ds > 1 ? "s" : "") +
                  "</div>";
              }
            }
            ul_str +=
              '<li id="' +
              input.id +
              "_li" +
              i +
              '"><div class="dtt disMMiclk"><div class="resultMmi_img disMMiclk" style="' +
              img_bg +
              '"><img src="data:image/png;base64,' +
              img +
              '" style="width:' +
              img_size +
              ";height:" +
              img_size +
              ";" +
              img_css +
              '"></div><div class="result_cont disMMiclk"><div class="highligher-search disMMiclk">' +
              pname +
              "</div>" +
              disDv +
              '<div class="madd disMMiclk">' +
              paddr +
              "</div>" +
              elc_dv +
              "</div></div></li>";
          }
          ul_str += "</ul>";
          var pwd_align = params.powered_align
              ? params.powered_align
              : "center",
            pwd_htm =
              "<div id='pwrd' style='text-align:" +
              pwd_align +
              "'>Powered by  <img style='vertical-align:middle;margin:2px;width:80px' src='" +
              mE.logo +
              "'> </div>";
          ul_str += pwd_htm;
          if (search_result) {
            search_result.innerHTML = ul_str;
            search_result.style.display = "inline";
            var ul = document.getElementById("MMIul_" + input.id);
            ul.onclick = function (e) {
              selected_num = null;
              if (e.path) {
                for (var i = 0; i < e.path.length; i++) {
                  try {
                    if (e.path[i].id && e.path[i].id.indexOf("_li") > 1)
                      selected_num = e.path[i].id.replace(input.id + "_li", "");
                  } catch (e) {}
                }
              }
              if (!selected_num && e.srcElement && e.srcElement.id)
                selected_num = e.srcElement.id.replace(input.id + "_li", "");
              else if (!selected_num && e.target) {
                selected_num = e.target.id.replace(input.id + "_li", "");
              }
              if (selected_num != null) {
                var clicked_dtt =
                  mE.search_result_data[input.id][parseInt(selected_num)];
                var u = mE.$("#mmi_search_" + input.id);
                if (u) u.style.display = "none";
                if (clicked_dtt.placeName) {
                  mE.$("#" + input.id).value =
                    clicked_dtt.placeName +
                    (clicked_dtt.placeAddress
                      ? ", " + clicked_dtt.placeAddress
                      : "");
                }
                var clb = "";
                if ("function" == typeof success_callback)
                  clb = success_callback;
                else if (params.click_callback) clb = params.click_callback;
                if (clb)
                  setTimeout(function () {
                    clb(mE.sE_return(input, [clicked_dtt]));
                  }, 0);
                return false;
              } else console.warn("failed to click");
            };
          }
        }
      },
      sE_return: function (input, clicked_dtt) {
        if (
          input &&
          input.id.indexOf(atob("bW1pU2VhcmNoXw==")) == -1 &&
          clicked_dtt &&
          mE.latlng === false
        ) {
          clicked_dtt.forEach(function (x) {
            if (x.latitude && x.eLoc) {
              delete x.latitude;
              delete x.entryLatitude;
              delete x.longitude;
              delete x.entryLongitude;
            }
          });
        }
        return clicked_dtt;
      },
      gwatch: "",
      geo: function (callback) {
        mE.gwatch = navigator.geolocation.getCurrentPosition(
          function (p) {
            callback(p);
            if (mE.gwatch) navigator.geolocation.clearWatch(mE.gwatch);
          },
          function (er) {
            console.warn(er.message);
            if (mE.gwatch) navigator.geolocation.clearWatch(mE.gwatch);
            callback(er);
          }
        );
      },
      catcode: function (code) {
        var rst =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkCh4NCzvhUGiFAAAAxklEQVQY00XJPytFYRwA4Of3nnNzr3Mx6ArJdMtVLIrVJ7DdkUk2oy9iEpuSr2BUTHwBs00nFEr503kNl2xPPXHAii1ZbcxRllNsxrbThCWlaQxyK6RhnNvRS1jzaUajH73ctmtWI5e5inVTJs1Z1Y87i0CpjQ0M1FpKY6NIt095z6HGjWG+VCh+Y1ncO/PuynU0Xlx4gHQCHaXxAvnNvmOJZBQt1VdAfJv4j0qhG4nQFBb4iy6qkaNjHjGKZ6/qyBnCh0f1D1MSMeJl2y1LAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTEwLTMwVDEzOjExOjQ4KzAwOjAwg01/6wAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0xMC0zMFQxMzoxMTo0OCswMDowMPIQx1cAAAAASUVORK5CYII=",
          fb =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAwwLAgqSwVIhAAAA1klEQVQY00XOvy5DYQBA8d9377U02qGTbkajP7F0sbWR2DB18RCNNzBik6gnMDMRYUCF6CIsFoNV1EDR9n6GSnrWk5yc0GTCkboxd2q6GXKnPhTNqnhx4NkXGTGGRz2prnUlfEVkhERD3UAUlW26CVd+QxMqihJVO75teAqvMc+QWDJjSk1Ja3iS5v8piYYVA/f2tNI82h6JOAj7FhXsOhw/J5Aca2JLlYI+SK9VRflD8mPNvIv+W2bBrZS2qoSOSaum45nPsnMpI2UYO2HOcnhPL3va/gCyQkb1wHGcWgAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyMC0wMy0xMlQxMTowMjowMyswMDowMNpI/CgAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjAtMDMtMTJUMTE6MDI6MDMrMDA6MDCrFUSUAAAAAElFTkSuQmCC",
          atm =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAwwLAzKj2Nv+AAABAElEQVQY0y2OvUqCYRhAz/N+jz9kWlI2KBRGQi1NLQUtXklbEDR2FW3R1FBEEHQFQTfQEgmJUyQYBDVY+ll+pu9PQ57xnOVI9RgAQ8Nfiyct++Q54VspTENNCvTE884AC1Ld4R8bWvwIQUmTpWcI3jnrxs5T8jiMlW05lGWVvblIJQSJBq3kVEe+KLtU2NCcHm2ulTL60j0bNhZm81InIWHdhDCchLCyVMjYSHNS5Smc88aqutCJF3PlYvPjaxKNuQVD6FBTNfVqef7q4aLtbIqAIwUJmNjetX/tc3/sDQBueq9Gbl6L2YOt7n0zMVOJgNKXcPk406+MmjEOPEDM5x+ZzWgIf8kmcQAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyMC0wMy0xMlQxMTowMzo0NSswMDowMNIQrNYAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjAtMDMtMTJUMTE6MDM6NDUrMDA6MDCjTRRqAAAAAElFTkSuQmC",
          apt =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAwwLBgr2rZclAAAAyUlEQVQY013QPUoDUQBF4e9NBhwxiFFiI7qBWKQTU/hDFhAQRNHeFTwEK7EPNi7ABQguIKWNpY1YiY3aaZEiYQSZZ+HYeC7c5nCbG4BI041vhyZDkPujpSNZNPFPhDo1GSciVOqOv4sooVR0NdHN3iqnKo2ewFp+5tySQj8teE5jGr15R67smQNNW/qmXkIc2TH14NExrnVsmHWXSy6MPGkZ4NKnddt2QyyUYNU9Nr2CmUyZkHL72toOUk7iK9SHrLj1IVg28D7ED2e1M3L2Xz/QAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTAzLTEyVDExOjA2OjA1KzAwOjAwsHNpaAAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wMy0xMlQxMTowNjowNSswMDowMMEu0dQAAAAASUVORK5CYII=",
          prkg =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAwwLCCHEkkPrAAAAp0lEQVQY03XOoU4DQQCE4W/3jhoM5jCYUklIQMFj8B48GY+AJQhUm5LUVcAhCAYM4sJd9xbF5hD91SR/ZjLhlMqtCwm9Dw/pKaSs9sdOb2auqTrLXRHBs3uNGyeuxnWVYhHf3sLSBkdhRjShjw4xGJWp7Nj1wcKlrJ3/vEzEmXPRaOuxZfLqy7tOm1fhszYUEW3ynTHmrDZ4nTRySCRs+TcF2pKiPfwCOlQ2mzz7huEAAAAldEVYdGRhdGU6Y3JlYXRlADIwMjAtMDMtMTJUMTE6MDg6MjkrMDA6MDArPzTSAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDIwLTAzLTEyVDExOjA4OjI5KzAwOjAwWmKMbgAAAABJRU5ErkJggg==",
          chm =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAwwLCjsLxtgTAAAA00lEQVQY0z3MMSvEcRzH8df3/7+T6RalLkkZPADTdUWewyVPgMigOHkGykDdZkAZDDcYdCxGGTyKS8mgpLC4uvv3M9z1/4zvT+93KHcIhnKZJMbwSCEksWpDpvv3FNBWNZJqsaNtFm82Y18+Fus6WvJJt1eZUjBtPY1iscTMZAXz0XEVWy79TvDQfaapa1vVmjk34MdJOs+btxogLLm24NNecRGDiuWyW9dy4F0/Q+a1PPruPOvXcCZvfmmoGejZ9Shx7AWV1I0PK/rpIb6TcDrR/wGCiDp6a4YV9AAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyMC0wMy0xMlQxMToxMDo1NSswMDowMDQDyIsAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjAtMDMtMTJUMTE6MTA6NTUrMDA6MDBFXnA3AAAAAElFTkSuQmCC",
          gym =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAwwLDDG9SZaLAAAA0ElEQVQY003QMSvEcRzH8df3f/8o5TKZPQJWnWThOZgMVgaX/6KoK5HJoO4J2Mh+SZRuUAYDi013znaXxYC4n4HOvcf38OndJwwoENKGjrMkN8xYWjJh1Wtclv5thbID3FvzVBoe+n7PWla8aFsOqHmD3Lp5J7Yca+QFv3rUpm3n6So6vjzmSZRN9ttZTdWpIrq6zCpVRmNBPZ7NuEtF9Pj0pSWPHeNu7ClSMz7oOwKZC3M+3dqPKfoO/yqzdK1qUU/DiIEmC5p2Tat7yIZO+AGtvz9FWr++hwAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyMC0wMy0xMlQxMToxMjo0NCswMDowMForE5wAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjAtMDMtMTJUMTE6MTI6NDQrMDA6MDArdqsgAAAAAElFTkSuQmCC",
          hosp =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAw0KDSB3nIpqAAAAf0lEQVQY04XPsQnCUBQF0PO/+aUSNxCLlLYOoOAkbuA2DuAKNg7gBGndQNQiRSCxMZAEgq95Fw487guntZuVe3vwCuSuth520cSMoe1C9ttBChmSMIQiXNRIiiHk9sObHdSeGkRLqQ+lozcWzjZ9qJoyfjBXjeqG2MJs6g9/4Qv+NRXhTblzyQAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyMC0wMy0xM1QxMDoxMzoyOCswMDowMMfYU0UAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjAtMDMtMTNUMTA6MTM6MjgrMDA6MDC2hev5AAAAAElFTkSuQmCC",
          hotl =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAwwLFgKytA1GAAAAu0lEQVQY01XNvy4EUQBG8d+9rjGSJRkZ5ZYiUUhEIxq9p1CzlYwHUElEJeJddBoqFYnQr3aRbGyC3avaP075neR8odl35zMLgmxMEF1rVywiWLaiUimypLD0fhp2nbt3adMIL86SoR3HWuQDG7bAtjrKaiVqC4aTk70oevDk103omVIm8z6cWHObVxVTE5ofXV+yKGkrxyKZU0/aAwNkSSvp6XgVZ/oj666SvkfP/vOtnxx642Jmbeg6+gPrWy9QN7bVzwAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyMC0wMy0xMlQxMToyMTo1OCswMDowMCP0pHQAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjAtMDMtMTJUMTE6MjE6NTgrMDA6MDBSqRzIAAAAAElFTkSuQmCC",
          train =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAwwLGzm2EZovAAAA3klEQVQY0z3MyypEcQDA4e9/5mhkITUWFrKiSca4FAsPIBubKW8gL+CUZ1DzBMrWjrLgBaRYjEtWWA9ZjNKYS2bmHAuXb/urX0goqJj26Xym9qzqR2TYMib1pI8h8yfK5pXkXWpIoqVg9zfEoZAdhBYYsRXdDOzZR2wzlPWRWrSSHoWHvkRVSD6M/o9P1Rx6yRDpqIO6pjcd29lsE7m1iltlnMkU1b2Gcn5KFJK22BB6ciJt9651ZLETG8hEAoI5RS2t2LEJV56sW5Aa6Or60ortGLOqZFzq3YU7DU3Nbw06SMFjp4GUAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTAzLTEyVDExOjI3OjUyKzAwOjAwipqLfQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wMy0xMlQxMToyNzo1MiswMDowMPvHM8EAAAAASUVORK5CYII=",
          pump =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAwwLHgntv17GAAAAtElEQVQY023LPyvEcRzA8df369M5F2VyV6QuZWBSNjEabSZ5EJfBwzB6GsablOkGj8GmlD93dcK5+H0Ncl14r6/e6UTJ+ciGT5AMnHshSGFLz6OkCIe2tV0FkqFLT77bsenYfgY1y5paWlbM6zowCkqV1lwYgRlvzmoP49dAUdf2053V9/sk+13DaWqq/kJf36x/joIQORl+KFMwdqOjEXYX65amYMGtSjfsmdNzPYHKumeDL1PoLhuUUhC2AAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTAzLTEyVDExOjMwOjA1KzAwOjAwJI9/LgAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wMy0xMlQxMTozMDowNSswMDowMFXSx5IAAAAASUVORK5CYII=",
          chrg =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAwwLHyy/oLvAAAAAz0lEQVQY0zXNvyuEcQDH8dfzvSc/yuIyPLmSDDKd/Au3GQwWXa78DdQZZbL7D/Qos8EfgAmDkhKb/IhBysLd4L5fwz0+06fPj95Zd8yuZQmZZ9tm3XonV1gzZ6imEwvauj6DICC61pNJSi37pkK1fVSKCNrO1W38F4fuREk0UDNiOqDmQenGnm8zjt0bN8iRXPj1pWHCqqYtPUWOaN2TMx0cWLIoMWSMKmyq40dfBnkFb2lULoiSLDd8zVdx8mHFpMtc35UXEZnkzakdr47+AIK2Od5lbpHJAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTAzLTEyVDExOjMxOjQwKzAwOjAwHT81TQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wMy0xMlQxMTozMTo0MCswMDowMGxijfEAAAAZdEVYdFNvZnR3YXJlAEFkb2JlIEltYWdlUmVhZHlxyWU8AAAAAElFTkSuQmCC",
          monu =
            "iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAQAAAD8fJRsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAwwLIQosaCVAAAAAp0lEQVQY01XPMWoCYRAF4O9f/yIo2lrkCDFFbuAx7IRAekGvEbD3AqniBbyDkDtYaKGisAqrrsW/uPFV782beTMTJkRNHTMfWPpykLtEvPvW1vOCvrmjsWVEYe9sIaHhrCBMkgxKTyxqGei6qZFZ+4lKb0bCP6M0VWZyczk4OUGqZFTdK0NDq2qP+Aj484tPr0nWxlXApb6gGq0CHyw9uNGxAztbBwV3saUtSugKuTwAAAAldEVYdGRhdGU6Y3JlYXRlADIwMjAtMDMtMTJUMTE6MzM6MDcrMDA6MDBYJ9UEAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDIwLTAzLTEyVDExOjMzOjA3KzAwOjAwKXptuAAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAASUVORK5CYII=",
          search =
            "iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAAyUlEQVR4AdXSAQTCQBiG4TAcQggwwAAhDBAiBAgBQggDDBCGECAMA4QQYAgBAALAMIRhgAADBFjvj2Dq7tJCLw+48+G2zs+r67qP3jcDcxR4VmAL55ORA6QSeyTIIWXo2YwsIR2hGmcRpMRm6IYc6s35CZKnG3Eh7QxvJy10Q2NIoebOFNLK9KmlVHMnguSb3ugMafLizEOFK5RpyEWFOzbwMUCAClJg+x8NkaFZiRhSbDvmYIQQa8yg0MVFM2bfX4ylcNoYY6TlHqwQY09H4hOrAAAAAElFTkSuQmCC";
        var codes = {
          FODRDS: rst,
          FODIND: rst,
          FODBAK: rst,
          FODFFD: rst,
          FODCON: rst,
          FODOTL: rst,
          FODOTH: rst,
          FODCOF: rst,
          FINBNK: fb,
          FINATM: atm,
          TRNARC: apt,
          TRNTRL: apt,
          PARKNG: prkg,
          PRKMBK: prkg,
          PRKTRK: prkg,
          PRKBUS: prkg,
          PRKMLT: prkg,
          PRKNOP: prkg,
          PRKWPM: prkg,
          PRKCYC: prkg,
          PRKCNT: prkg,
          PRKRDS: prkg,
          PRKUNG: prkg,
          TRNPRK: prkg,
          PRKSRF: prkg,
          MDS24H: chm,
          MDSJAN: chm,
          HLTMDS: chm,
          HLTGYM: gym,
          HLTHSP: hosp,
          HLTAMB: hosp,
          HLTBLD: hosp,
          HLTEYE: hosp,
          HSPAUR: hosp,
          HSPCAN: hosp,
          HSPCHD: hosp,
          HSPDNH: hosp,
          HSPENT: hosp,
          HSPEYH: hosp,
          HSPHMH: hosp,
          HSPHRH: hosp,
          HSPMAT: hosp,
          HSPMNH: hosp,
          HSPNAT: hosp,
          HSPORH: hosp,
          HSPURO: hosp,
          HSPVTH: hosp,
          HOTNOP: hotl,
          HOTRES: hotl,
          HOTSAP: hotl,
          PREHRG: hotl,
          HOTPRE: hotl,
          HOTYTH: hotl,
          HOTALL: hotl,
          HOTHST: hotl,
          PRENRT: hotl,
          HOTHRG: hotl,
          NOPHRG: hotl,
          METPLR: train,
          TRNMET: train,
          TRNRAL: train,
          TRNRAM: train,
          TRNRWB: train,
          TRNRWT: train,
          TRNPMP: pump,
          TRNCGS: chrg,
          TRNECS: chrg,
          TRNSPS: chrg,
          CGSBMW: chrg,
          HISMON: monu,
          search: search,
        };
        return codes[code];
      },
      ds: function (lat1, lon1, lat2, lon2, unit) {
        if (lat1 == lat2 && lon1 == lon2) {
          return 0;
        } else {
          var radlat1 = (Math.PI * lat1) / 180,
            radlat2 = (Math.PI * lat2) / 180,
            theta = lon1 - lon2,
            radtheta = (Math.PI * theta) / 180;
          var dist =
            Math.sin(radlat1) * Math.sin(radlat2) +
            Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
          if (dist > 1) dist = 1;
          dist = Math.acos(dist);
          dist = (dist * 180) / Math.PI;
          dist = dist * 60 * 1.1515;
          dist = dist * 1.609344;
          return dist;
        }
      },
      eMinx: 1000,
      eM: function (p) {
        if (!p || (!p.map && p.icon !== false)) {
          console.error("Map Required - " + method[2]);
          return false;
        }
        var map = "";
        if (p.map) map = mE.chkMap(p.map);
        if (p && p.eloc) {
          if (typeof p.eloc == "string") {
            p.eloc = [p.eloc];
          }
          var elocs = p.eloc.toString().toUpperCase().split(",");
          if (elocs[0].length > 5) {
            var markergroup = [];
            var icon = {
              url: mE.mkr_url,
              width: 36,
              height: 45,
              offset: [18, 45],
              popupAnchor: [0, -40],
            };
            if (p.icon != undefined && (p.icon.url || p.icon.html)) {
              icon = p.icon;
              if (!icon.offset)
                icon.offset = [
                  icon.width ? icon.width / 2 : 0,
                  icon.height ? icon.height : 0,
                ];
              if (icon.width < 0) {
                console.error(
                  method[2] +
                    " - please provide icon height & width to display properly"
                );
                icon.width = 35;
              }
              if (!icon.popupAnchor)
                icon.popupAnchor = [0, icon.height ? -(icon.height / 2) : -2];
            }
            if (p.icon === false) icon = "";
            var eloc_gt = "";
            for (var i = 0; i < p.eloc.length; i++) {
              var el = p.eloc[i];
              if (p.fitbounds === true && el.indexOf(",") != -1) {
                map.setView(el.split(","), 17);
              } else if (el && el.indexOf(",") > 1 && map) {
                var html =
                    p.html && p.html[i]
                      ? "string" == typeof p.html
                        ? p.html
                        : p.html[i]
                      : "",
                  popup = p.popupHtml
                    ? "string" == typeof p.popupHtml
                      ? p.popupHtml
                      : p.popupHtml[i]
                    : "",
                  el_arr = p.eloc[i].split(","),
                  lt = parseFloat(el_arr[0]),
                  ln = parseFloat(el_arr[1]),
                  elcCoord = el_arr[2] ? el_arr[2] : lt + "," + ln;
                if (lt && ln) {
                  if (p.icon && p.icon[elcCoord]) {
                    icon = p.icon[elcCoord];
                  }
                  if (p.cType == 1) {
                    var ltt = lt;
                    lt = ln;
                    ln = ltt;
                  }
                  var mkr = mE.addMarker(
                    map,
                    elcCoord,
                    lt,
                    ln,
                    icon,
                    html,
                    popup,
                    p
                  );
                  markergroup.push(mkr);
                }
              } else eloc_gt = (eloc_gt ? eloc_gt + "," : "") + el;
            }
            if (eloc_gt) {
              var u =
                mE.pth +
                "/map_v3/?elm=" +
                btoa(eloc_gt.toString()) +
                "&k=" +
                mE.k +
                "&a=" +
                mE.au;
              mE.jP(
                u,
                1,
                function (data) {
                  if (data) {
                    if (data == "auth") res = "error-auth-failed";
                    if (
                      typeof data == "string" &&
                      data.indexOf("error") != -1
                    ) {
                      if (p.callback) p.callback(data);
                      else console.error(data);
                      return false;
                    }
                    if (data && data.results) {
                      var res = data.results;
                      for (var i = 0; i < res.length; i++) {
                        var eloc = res[i].eloc,
                          lat = res[i].latitude,
                          lng = res[i].longitude;
                        if (lat && lng) {
                          var elcs = p.eloc.join("-").toUpperCase().split("-"),
                            indx = elcs.indexOf(eloc),
                            popup = "";
                          if (p.popupHtml) {
                            if (typeof p.popupHtml == "object") {
                              if (indx != -1) {
                                if (p.popupHtml[indx])
                                  popup = p.popupHtml[indx];
                              }
                            } else popup = p.popupHtml;
                          }
                          var html = "";
                          if (p.html) {
                            if (typeof p.html == "object") {
                              if (indx != -1) {
                                if (p.html[indx]) html = p.html[indx];
                              }
                            } else html = p.html;
                          }
                          if (map) {
                            if (p.fitbounds === true) {
                              map.setView([lat, lng], 17);
                            } else {
                              if (p.icon && p.icon[eloc]) {
                                icon = p.icon[eloc];
                              }
                              var mkr = mE.addMarker(
                                map,
                                eloc,
                                lat,
                                lng,
                                icon,
                                html,
                                popup,
                                p
                              );
                              markergroup.push(mkr);
                            }
                          } else markergroup.push([lat, lng, eloc]);
                        }
                      }
                    }
                  }
                },
                false
              );
            }
            var return_no = mE.eMNo++;
            mE.emMkrs[return_no] = markergroup;
            return {
              id: return_no,
              map: map,
              remove: function () {
                if (this && this.id != undefined) {
                  var mkrs = mE.emMkrs[this.id];
                  if (mkrs) {
                    if (map.type == "L") {
                      for (var i = 0; i < mkrs.length; i++) {
                        mkrs[i].remove();
                      }
                    } else if (map.type == "M") {
                      MapmyIndia.remove({ map: this.map, layer: mkrs });
                    }
                    delete mE.emMkrs[this.id];
                  }
                  return true;
                }
              },
              setPopup: function (params) {
                if (params === undefined) return false;
                if (this && this.id != undefined) {
                  var mkrs = mE.emMkrs[this.id],
                    t = this.map.type;
                  if (!mkrs) return false;
                  for (var i = 0; i < mkrs.length; i++) {
                    if (
                      params.eloc &&
                      mkrs[i].eloc.toUpperCase() !== params.eloc.toUpperCase()
                    )
                      continue;
                    if (t == "L") {
                      var con = mkrs[i]._popup.getContent();
                      if (con) {
                        mkrs[i]._popup.setContent(params.content);
                      }
                    } else if (t == "M") {
                      mkrs[i].getPopup().setHTML(params.content);
                    }
                  }
                }
              },
              fitbounds: function (options) {
                if (this && this.id != undefined && options !== false)
                  mE.fteM(this, options);
                return this;
              },
              addListener: function (e, c) {
                if (
                  this &&
                  this.id != undefined &&
                  e &&
                  "function" == typeof c
                ) {
                  var mkrs = mE.emMkrs[this.id],
                    t = this.map.type;
                  if (!mkrs) return false;
                  for (var i = 0; i < mkrs.length; i++) {
                    if (t == "L") {
                      mkrs[i].on(e, function (d) {
                        var r = { eloc: this.eloc, event: d.originalEvent };
                        if (mE.latlng) r.latlng = d.target._latlng;
                        c(r);
                      });
                    } else if (t == "M") {
                      mkrs[i].addListener(e, function (d) {
                        var e = d.eloc;
                        if (!e) e = d.target.eloc;
                        var r = { eloc: e, event: d._element };
                        if (mE.latlng)
                          r.latlng = d._lngLat ? d._lngLat : d.target._lngLat;
                        c(r);
                      });
                    }
                  }
                }
              },
              removeListeners: function (e) {
                if (this && this.id != undefined && e) {
                  var mkrs = mE.emMkrs[this.id],
                    t = this.map.type;
                  if (!mkrs) return false;
                  for (var i = 0; i < mkrs.length; i++) {
                    if (t == "L") {
                      mkrs[i].off(e);
                    } else if (t == "M") {
                      mkrs[i].clearListeners(e);
                    }
                  }
                }
              },
              setIcon: function (u, ind_eloc) {
                if (this && this.id != undefined && u) {
                  var mkrs = mE.emMkrs[this.id],
                    t = this.map.type;
                  if (!mkrs) return false;
                  for (var i = 0; i < mkrs.length; i++) {
                    if (
                      ind_eloc &&
                      mkrs[i].eloc.toUpperCase() !== ind_eloc.toUpperCase()
                    )
                      continue;
                    if (t == "L") {
                      var icn = mkrs[i].getIcon();
                      if (icn && icn.options) icn.options.iconUrl = u;
                      mkrs[i].setIcon(icn);
                    } else if (t == "M") {
                      mkrs[i].setIcon(u);
                    }
                  }
                }
              },
              fire: function (elc) {
                if (elc) {
                  var mkrs = mE.emMkrs[this.id],
                    t = this.map.type;
                  if (!mkrs) return false;
                  for (var i = 0; i < mkrs.length; i++) {
                    if (
                      elc &&
                      mkrs[i].eloc.toUpperCase() == elc.toUpperCase()
                    ) {
                      if (t == "L") {
                        mkrs[i].fire("click");
                        mkrs[i]._bringToFront();
                      } else if (t == "M") {
                        if (mkrs[i]._element && mkrs[i]._element.id) {
                          var mid = mE.$("#" + mkrs[i]._element.id);
                          if (mid) mid.click();
                        }
                      }
                      continue;
                    }
                  }
                }
              },
              setTop: function (elc) {
                if (elc) {
                  var mkrs = mE.emMkrs[this.id],
                    t = this.map.type;
                  if (!mkrs) return false;
                  for (var i = 0; i < mkrs.length; i++) {
                    if (
                      elc &&
                      mkrs[i].eloc.toUpperCase() == elc.toUpperCase()
                    ) {
                      if (t == "L") {
                        mkrs[i].setZIndexOffset(mE.eMinx);
                        mE.eMinx = mkrs[i]._zIndex;
                      } else if (t == "M") {
                        if (mkrs[i]._element && mkrs[i]._element.id) {
                          var mid = mE.$("#" + mkrs[i]._element.id);
                          if (mid) mid.click();
                        }
                      }
                    }
                  }
                } else {
                  if (this && this.id != undefined) {
                    var mkrs = mE.emMkrs[this.id];
                    if (mkrs) {
                      if (map.type == "L") {
                        for (var i = 0; i < mkrs.length; i++) {
                          mkrs[i].setZIndexOffset(mE.eMinx);
                        }
                      }
                    }
                  }
                }
                mE.eMinx++;
              },
            };
          } else console.error("Invalid eLoc passed - " + method[2]);
        } else console.error("No valid map or elocs received - " + method[2]);
      },
      addMarker: function (map, eloc, lat, lng, icon, html, popup, p) {
        var mkr = "",
          mWidth = p.width ? p.width : icon.width,
          mHeight = p.height ? p.height : icon.height,
          popupOpt = p.popupOptions,
          drag = p.draggable;
        if (!popupOpt) popupOpt = {};
        if (!popupOpt.className) popupOpt.className = "mmi_popup";
        if (map.type == "L") {
          var htm,
            iconP = {
              iconUrl: icon.url,
              className: "",
              iconSize: [mWidth, mHeight],
              iconAnchor: p.iconAnchor,
              popupAnchor: icon.popupAnchor ? icon.popupAnchor : [0, 0],
            };
          if (html && p.icon && p.icon.url) {
            htm = "";
            if (icon.url) {
              htm =
                "<div style='position:relative;text-align:center'><img  src='" +
                icon.url +
                "' style='height:100%;width:100%'><div style='position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);'>" +
                html +
                "</div></div>";
            }
            iconP.html = htm;
            var icon = L.divIcon(iconP);
          } else if (html || (p.icon && p.icon.html)) {
            iconP.html = p.icon && p.icon.html ? p.icon.html : html;
            var icon = L.divIcon(iconP);
          } else if (icon.html) {
            iconP.html = icon.html;
            var icon = L.divIcon(iconP);
          } else var icon = L.icon(iconP);
          if (p.offset && Array.isArray(p.offset))
            icon.options.iconAnchor = p.offset;
          else if (p.icon && p.icon.offset && Array.isArray(p.icon.offset))
            icon.options.iconAnchor = p.icon.offset;
          else if (iconP.iconAnchor == undefined && mWidth && mHeight)
            icon.options.iconAnchor = [mWidth / 2, mHeight];
          mkr = L.marker([lat, lng], { icon: icon, draggable: drag }).addTo(
            map
          );
          if (popup) {
            if (popupOpt && popupOpt.offset == "") popupOpt.offset = [0, -10];
            mkr.bindPopup(popup, popupOpt);
            if (popupOpt.openPopup) mkr.openPopup();
          }
        } else if (map.type == "M") {
          if ("function" == typeof MapmyIndia.Marker) {
            if (icon.html || html) icon.url = false;
            var dt = {
              map: map,
              position: { lat: lat, lng: lng },
              width: mWidth,
              height: mHeight,
              icon: icon.url,
              html: icon.html ? icon.html : html,
              popupHtml: popup,
              popupOptions: popupOpt,
              draggable: drag,
            };
            if (p.offset && Array.isArray(p.offset)) dt.offset = p.offset;
            mkr = MapmyIndia.Marker(dt);
          } else console.error("method maker not found - " + method[2]);
        }
        mkr.eloc = eloc;
        return mkr;
      },
      fteM: function (mobj, op) {
        if (mobj && "object" == typeof mobj) {
          if (!Array.isArray(mobj)) mobj = [mobj];
          var m_pts = [];
          for (var i = 0; i < mobj.length; i++) {
            var id = mobj[i].id;
            if (id !== undefined) {
              var mkrs = mE.emMkrs[id];
              if (mkrs) {
                for (var j = 0; j < mkrs.length; j++) {
                  var coord = mkrs[j]._latlng
                    ? mkrs[j]._latlng
                    : mkrs[j]._lngLat;
                  if (coord.lat && coord.lng)
                    m_pts.push([parseFloat(coord.lat), parseFloat(coord.lng)]);
                }
              }
            }
          }
          if (m_pts && m_pts.length >= 1) {
            var map = mobj[0] ? mobj[0].map : "";
            if (map) {
              if (map.type == "L") {
                if (op && op.padding && "object" !== typeof op.padding)
                  op.padding = [op.padding, op.padding];
                map.fitBounds(m_pts, op ? op : { padding: [50, 50] });
              } else if (map.type == "M") {
                if (!op) op = { padding: 50 };
                MapmyIndia.fitBounds({
                  map: map,
                  bounds: m_pts,
                  options: op,
                  cType: 0,
                });
              }
            }
          }
        }
      },
      pp_search_dt: "",
      pp: function (p, success_callback) {
        var reg = p.region ? p.region : "";
        if (p && p.access_token) mE.k = btoa(p.access_token);
        if (p && p.map) {
          var id = "mmi",
            wt = 100,
            wh = 100,
            searchInputId = "",
            map = mE.chkMap(p.map);
          if (map._container) {
            wt = map._container.offsetWidth;
            wh = map._container.offsetHeight;
            id = map._container.id;
          }
          var sethtml = function (type) {
            if (map._container) {
              wt = map._container.offsetWidth;
              wh = map._container.offsetHeight;
              id = map._container.id;
            }
            var nid = "mmiPicker_" + id,
              topdHt = 42;
            searchInputId = "mmiSearch_" + id;
            var close_clbk =
              "document.getElementById('" + nid + "').style.display='none'";
            var close_btn =
              '<span id="closeBTN_' +
              id +
              '" style="background: #eee;color:#c2c2c2;padding: 5px 7px;font-size:15px;border-radius: 5px;margin-right:4px;cursor:pointer">X</span>';
            if (p.closeBtn == false) close_btn = "";
            var topText = "Place Picker";
            if (p.topText) topText = p.topText;
            var searchDv =
              '<div id="Dv_' +
              searchInputId +
              '" style="float:right;background:#eee;;margin:5px;border-radius:5px;cursor:pointer;">' +
              "<img onclick=\"var inp=mE.$('#" +
              searchInputId +
              "');if(inp.style.display=='none') inp.style.display='inline';else inp.style.display='none';\" src=\"https://apis.mapmyindia.com/map_v3/srarch1.png\" style=\"float:left;padding:6px\" title=\"search location! - enable/disable\">" +
              '<input type="text" id="' +
              searchInputId +
              '" style="width:250px;border: 2px solid #ccc;padding:6px;outline-style:none;outline:none;border-radius: 5px;" placeholder="Search places or eLoc..." required="" spellcheck="false" autocomplete="off">' +
              "</div>";
            if (p.search == false) searchDv = "";
            var style_dv =
              "background:transparent;pointer-events:none;width:" +
              wt +
              "px;height:" +
              wh +
              "px;";
            var HTM =
              "<style>.mmiPicker{margin:0 !important;pointer-events:none !important}.pPsubm{cursor:pointer;margin:5px;margin-left:calc(50% - 40px);background:#ccc;border:1px solid #888;width:80px;border-radius:3px;padding:5px}</style>";
            if (type == "M")
              style_dv += "left:-10px;top:-10px;;position:absolute;";
            var pin = mE.pth + "/map_v3/pin.png",
              pinHt = 39;
            if (p.pinImage) pin = p.pinImage;
            if (p.pinHeight) pinHt = p.pinHeight;
            HTM +=
              '<div id="' +
              nid +
              '" class="default_div" style="' +
              style_dv +
              '">' +
              '<div id="mmiPickerTop" style="display:' +
              (p.header === false ? "none" : "block") +
              ";border:1px solid #ddd;pointer-events:all;width:calc(100% - 2px);height:" +
              topdHt +
              'px;text-align:center;font-size:20px;background:#fff;border-bottom:1px solid #ccc">' +
              '<div style="float:left;padding:5px;line-height:30px;">' +
              close_btn +
              topText +
              "</div>" +
              searchDv +
              "</div>" +
              '<img src="' +
              pin +
              '" style="position:absolute;height:' +
              pinHt +
              "px;min-height:28px;top:0;bottom:" +
              pinHt +
              'px;left:0;right:0;margin:auto">' +
              '<div id="mmiPickerBot" style="display:' +
              (p.callback ? "block" : "none") +
              ';position:absolute;bottom:1px;pointer-events:all;width:100%;text-align:center;padding:10px;font-size:15px;background:#fff;border-bottom:1px solid #ccc">' +
              '<img src="' +
              MapmyIndia.logo +
              '" style="position:absolute;top:-22px;left:2px">' +
              "Move the map to get desired location." +
              '<div id="submt_' +
              id +
              '" class="pPsubm">Done</div>' +
              "</div>" +
              "</div>";
            return HTM;
          };
          if (map.type == "L") {
            if (mE.pickCtrol[id] && mE.pickCtrol[id]._map) {
              mE.pickCtrol[id].remove();
            }
            mE.pickCtrol[id] = mE.ctrl(map, sethtml(), "mmiPicker", "topleft");
            map.on("resize", function () {
              if (
                mE.$("#mmiPicker_" + map._container.id).style.display != "none"
              )
                return mE.pp(p);
            });
          } else if (map.type == "M") {
            if (mE.pickCtrol[id] && mE.pickCtrol[id].map)
              map.removeControl(mE.pickCtrol[id]);
            mE.pickCtrol[id] = MapmyIndia.addControl({
              map: map,
              html: sethtml("M"),
              position: "top-left",
            });
            map.on("resize", function () {
              var ppd = mE.$("#mmiPicker_" + map._container.id);
              if (ppd && ppd.style.display != "none") return mE.pp(p);
            });
          }
          if (p.location && p.location.lat) {
            map.setView(
              [p.location.lat, p.location.lng],
              p.location.zoom ? p.location.zoom : 17
            );
          }
          if (p.search !== false) {
            var u =
              mE.pth + "/map_v3/?q=bW1pMDAw&tk=0&k=" + mE.k + "&a=" + mE.au;
            mE.jP(
              u,
              1,
              function (data) {
                if (data && data.indexOf("error-") != -1) {
                  mE.$("#Dv_" + searchInputId).style.display = "none";
                  console.log("search-API-" + data);
                }
              },
              false
            );
            new MapmyIndia.search(
              mE.$("#" + searchInputId),
              {
                map: map,
                region: reg,
                height: 250,
                bridge: false,
                filter: p.filter ? p.filter : "",
                hyperLocal: p.hyperLocal ? p.hyperLocal : false,
                pod: p.pod ? p.pod : "",
                tokenizeAddress: true,
                fitbounds: true,
              },
              function (d) {
                if (d && d[0]) {
                  var dt = d[0];
                  var lt = dt.latitude,
                    ln = dt.longitude,
                    eloc = dt.eLoc;
                  if (lt && ln) {
                    map.setView([lt, ln], 17, { animate: false });
                    var ctr = map.getCenter();
                    lt = ctr.lat;
                    ln = ctr.lng;
                  } else {
                    mE.eM({ map: map, eloc: eloc, fitbounds: true });
                  }
                  if (dt) {
                    if (!lt) {
                      var ctr = map.getCenter();
                      lt = ctr.lat;
                      ln = ctr.lng;
                      dt.cord = "no";
                    }
                    dt.lat = lt;
                    dt.lng = ln;
                    mE.pp_search_dt = dt;
                  }
                  if (dt.placeName)
                    mE.$("#" + searchInputId).value = dt.placeName;
                }
              }
            );
            mE.$("#" + searchInputId).style.display = "none";
          }
          try {
            mE.$(
              "#mmiPicker_" + map._container.id
            ).parentElement.parentElement.style.zIndex = 9999;
          } catch (e) {}
          if (mE.$("#closeBTN_" + id)) {
            mE.$("#closeBTN_" + id).addEventListener("click", function () {
              if (p.closeBtn_callback)
                close_clbk = p.closeBtn_callback({ closed: true });
              else if (map.type == "L") {
                if (mE.pickCtrol[id]) mE.pickCtrol[id].remove();
              } else if (map.type == "M") {
                if (mE.pickCtrol[id] && mE.pickCtrol[id].map)
                  map.removeControl(mE.pickCtrol[id]);
              }
            });
          }
          if ("function" == typeof p.callback) {
            mE.$("#submt_" + id).addEventListener("click", function () {
              var ctrl = map.getCenter();
              mE.ppCall(ctrl, reg, mE.k, p.callback);
            });
          } else {
            mE.$("#submt_" + id).style.display = "none";
          }
          return {
            map: map,
            remove: function () {
              if (this && this.map != undefined) {
                id = map._container.id;
                if (this.map.type == "L") {
                  if (mE.pickCtrol[id]) mE.pickCtrol[id].remove();
                } else if (map.type == "M") {
                  if (mE.pickCtrol[id]) map.removeControl(mE.pickCtrol[id]);
                }
              }
            },
            setLocation: function (l) {
              if (this.map && l.lat && l.lng) {
                this.map.setView([l.lat, l.lng], l.zoom ? l.zoom : 17);
                return true;
              } else return false;
            },
            getLocation: function () {
              if (this.map) {
                return mE.ppCall(this.map.getCenter(), reg, mE.k);
              }
            },
          };
        } else if (p && p.location) {
          if (p.location.lat) {
            var rt = mE.ppCall(p.location, reg, mE.k);
            if (p.callback) p.callback(rt);
            else return rt;
          }
        } else
          console.error(
            "please provide map object or points for placePicker Plugin!"
          );
      },
      ppCall: function (pt, reg, token, callb) {
        var lat = pt.lat,
          lng = pt.lng,
          search_dt = mE.pp_search_dt;
        if (search_dt && search_dt.lat == lat && search_dt.lng == lng) {
          var info = search_dt;
          if (!search_dt.area) {
            var info = search_dt.addressTokens;
            if (!info) info = {};
            info.area = "India";
            info.lat = search_dt.cord == "no" ? "" : search_dt.latitude;
            info.lng = search_dt.cord == "no" ? "" : search_dt.longitude;
            info.eLoc = search_dt.eLoc;
            info.formatted_address =
              search_dt.placeName +
              (search_dt.placeAddress ? ", " + search_dt.placeAddress : "");
            info.poi_dist = "";
            info.street_dist = "";
            info.responsecode = 200;
          }
          if (callb) callb(info);
          else return info;
        } else if (lat) {
          var res = "";
          var d,
            u =
              mE.pth +
              "/map_v3/?pprv=bM!" +
              btoa(lat + "," + lng) +
              "&reg=" +
              btoa(reg) +
              "&k=" +
              token +
              "&a=" +
              mE.au;
          mE.jP(
            u,
            1,
            function (data) {
              if (
                data &&
                "object" !== typeof data &&
                data.indexOf("error-") != -1
              ) {
                data = { error: data };
              }
              try {
                res = data.results[0];
                res.responsecode = data.responseCode;
              } catch (e) {
                res = data;
                res.responsecode = 401;
              }
            },
            false
          );
          if (res) {
            mE.pp_search_dt = res;
            if (callb) callb(res);
            else return res;
          }
        } else return "wrong points";
      },
      chkMap: function (mp) {
        var type = "";
        if (!mp) return false;
        if (mp && typeof mp.style == "object") type = "M";
        else if (mp && typeof mp.options == "object") type = "L";
        mp.type = type;
        return mp;
      },
      ds_dt: [],
      ds4: function (p, cl) {
        if (p.callback && !cl) cl = p.callback;
        if ("function" != typeof cl) {
          console.error(mE.Ncl + method[4]);
          return false;
        }
        if (!p || !p.coordinates) {
          var r =
            'Please pass coordinates as a string ie. "123ZRR;77.2222,28.222;78.222,28.2222" - ' +
            "di" +
            "st" +
            "ance method";
          cl(r);
        } else {
          if (!mE.clm[1])
            console.error(
              "CORS not enabled for your key, please mail us to enable."
            );
          var u = [
            p.resource ? p.resource : "distance_matrix",
            p.profile ? p.profile : "driving",
            p.rtype ? p.rtype : 0,
            p.region ? p.region : "ind",
            p.sources ? p.sources.replace(/\,/g, ";") : 0,
            p.destinations ? p.destinations.replace(/\,/g, ";") : "",
            p.coordinates.split(";"),
            "htt" +
              "ps://" +
              "ap" +
              "is." +
              "ma" +
              "pm" +
              "yi" +
              "ndi" +
              "a." +
              "co" +
              "m/" +
              "adv" +
              "anc" +
              "edm" +
              "aps/v" +
              "1/",
          ];
          var cord = "";
          for (var i = 0; i < u[u.length - 2].length; i++) {
            var cr = u[u.length - 2][i].split(","),
              cr1 = parseFloat(cr[0]),
              cr2 = parseFloat(cr[1]);
            if (cr1 && cr2 && u[3] == "ind") {
              if (cord) cord += ";";
              if (cr1 > cr2) cord += cr1 + "," + cr2;
              else cord += cr2 + "," + cr1;
            } else if (u[u.length - 2][i].length == 6) {
              if (cord) cord += ";";
              cord += cr[0];
            } else {
              cord += cord ? ";" : "" + cr.join(";");
            }
          }
          if (cord.indexOf(";") == -1) {
            var r = {
              error: "please check passed coordinates, minimum 2 require.",
            };
            cl(r);
          }
          url =
            u[u.length - 1] +
            atob(mE.k) +
            "/" +
            u[0] +
            "/" +
            u[1] +
            "/" +
            cord +
            "?rtype=" +
            u[2] +
            "&region=" +
            u[3];
          if (u[4] || u[5]) {
            url += "&sources=" + u[4] + "&destinations=" + u[5];
          }
          if (mE.ds_dt && mE.ds_dt[0] == url && mE.ds_dt[1]) {
            cl(mE.ds_dt[1]);
          } else {
            this.jP(url, "jp", function (r) {
              mE.ds_dt = [url, r];
              cl(r);
            });
          }
        }
      },
      nr_mkr: [],
      nrn: 0,
      nr: function (p) {
        if (p && p.hyperLink) {
          var l = p.hyperLink.split(/&|=/);
          if (l) {
            var refl = l.indexOf("refLocation");
            if (refl > 1) p.refLocation = l[refl + 1];
            var keyl = l.indexOf("keywords");
            if (keyl > 1) p.keywords = l[keyl + 1];
          }
        }
        var m;
        if (!p || !p.keywords || (!p.keywords && !p.refLocation)) {
          m = "Required keywords & refLocation - " + method[6];
        }
        if (p.divId && "string" === typeof p.divId)
          p.divId = mE.$("#" + p.divId);
        if (p && p.access_token) mE.k = btoa(p.access_token);
        if ("object" === typeof p.keywords) {
          if (p.divId) {
            var select = "",
              btnN = "Search Location";
            for (var k in p.keywords) {
              if (k !== "0") {
                select +=
                  "<label><input type='checkbox' name='MMIchkbx_" +
                  p.divId.id +
                  "' value='" +
                  k +
                  "'> " +
                  p.keywords[k] +
                  "</lable> ";
              }
            }
            if (select) {
              var resId = "MMIres_" + p.divId.id,
                css =
                  "<style>.mmiNrSl{border: 1px solid #f9f3f3;margin-top: 4px;border-radius:5px;background:#fff;padding:10px}.MMInrbx{border: 1px solid #ccc;background: #efefef;padding: 5px;margin: 6px 0;border-radius: 3px;}</style>",
                sid = "mmiSearch_" + p.divId.id,
                ht =
                  '<div class="mmiNrSl"><span>Find what? </span><div class="MMInrbx">' +
                  select +
                  "</div>" +
                  '<div style="overflow:hidden;border:1px solid #ccc;border-radius: 5px;"><input type="text" id="' +
                  sid +
                  '" style="border:none;width:100%;padding:6px;outline-style:none;outline:none;" placeholder="Near where?" required="" spellcheck="false" autocomplete="off"></div>' +
                  css +
                  '<center><button id="MMInrbtn_' +
                  p.divId.id +
                  '" style="width:150px;cursor:pointer;margin-top:10px;padding:5px;border: 1px solid #ccc;">' +
                  btnN +
                  "</button><center>" +
                  '</div><div id="' +
                  resId +
                  '" style="width:100%;overflow-y:auto;"></div>';
              p.divId.innerHTML = ht;
              p.divId.style.display = "inline";
              mE.sE(
                mE.$("#" + sid),
                {
                  map: map,
                  height: 250,
                  bridge: false,
                  tokenizeAddress: true,
                  geolocation: p.geolocation,
                  searchChars: p.searchChars,
                },
                function (d) {
                  if (d && d[0]) {
                    d = d[0];
                    var lt = d.latitude,
                      ln = d.longitude,
                      eloc = d.eLoc,
                      nm = d.placeName;
                    mE.$("#" + sid).value = nm;
                    p.refLocation = lt ? lt + "," + ln : eloc;
                  }
                }
              );
              var slbxcat = document.getElementsByName(
                "MMIchkbx_" + p.divId.id
              );
              mE.$("#MMInrbtn_" + p.divId.id).onclick = function () {
                var cats = "";
                for (var i = 0; i < slbxcat.length; i++) {
                  if (slbxcat[i].checked === true) {
                    cats += (cats ? ";" : "") + slbxcat[i].value;
                  }
                }
                if (!cats && slbxcat[0]) {
                  cats = slbxcat[0].value;
                  slbxcat[0].checked = true;
                }
                if (cats) p.keywords = cats;
                var sr = mE.$("#" + sid);
                if (!sr.value || !p.refLocation) {
                  sr.focus();
                  return false;
                }
                var pht = p.divId.style.height;
                p.divId = resId;
                if (!p.divHeight && pht < 1) p.divHeight = "400px";
                if (p.keywords && p.refLocation) {
                  this.innerHTML = "Loading..";
                  var r = mE.nr(p);
                  this.innerHTML = btnN;
                  return r;
                }
              };
            } else m = "provide selction category ie. {'finatm':'Atms'}";
          } else
            m =
              "Provide a divId & selection categories as JSON object- " +
              method[6];
        } else if (!m) {
          var ht = "",
            hID = "",
            el_arr = [],
            el_pop = [],
            rtn,
            mkr = "",
            ftr = p.filter ? p.filter : "",
            pr = [
              p.page ? p.page : 0,
              p.sortBy ? p.sortBy : "",
              p.radius ? p.radius : "",
              p.bounds ? p.bounds : "",
              p.pod ? p.pod : "",
            ],
            u =
              mE.pth +
              "/map_v3/?nr=" +
              btoa(p.keywords) +
              "&l=" +
              btoa(p.refLocation.toString()) +
              "&p=" +
              pr[0] +
              "&s=" +
              pr[1] +
              "&r=" +
              pr[2] +
              "&b=" +
              pr[3] +
              "&pd=" +
              pr[4] +
              "&ftr=" +
              btoa(ftr) +
              "&k=" +
              mE.k +
              "&a=" +
              mE.au;
          this.jP(u, 1, function (data) {
            if (
              data &&
              "object" !== typeof data &&
              data.indexOf("error-") != -1
            ) {
              m = data;
              data = { error: data };
            } else if (data && data.hasOwnProperty("suggestedLocations")) {
              rtn = data;
              var suggloc = data.suggestedLocations;
              var rcnum = 0,
                css =
                  "<style>.nrMMImain{overflow-y:auto;font-family: arial;background:#efefef;padding:7px;color:#212121;}.nrMMIot{background: #fff;cursor:pointer;padding: 5px;border-radius: 5px;margin: 5px 0;} .nrMMIot *{pointer-events:none}" +
                  ".nrMMIot h3{position: relative;padding-right:50px;margin: 6px 0;font-size: 14px;color: #555;} .nrMMIot span{color:#666;font-size:14px} .nrMMIds{position: absolute;right: 0;top: 3px;font-size:12px;color:#212121} " +
                  ".MMIpin{border-radius:4px;width:25px;height:25px;line-height:25px;background: #771717;text-align: center;display: inline-block;vertical-align: bottom;color: #fff;border: 1px solid #fff;font-size: 25px;}.MMIpin:after{content: '';position: absolute;left: 4px;right: 0;width: 0;margin-top: 22px;height: 0;border-top: 10px solid #771717;border-left: 10px solid transparent;border-right: 10px solid transparent;}" +
                  "</style>";
              suggloc.forEach(function (d) {
                var pn = d.placeName,
                  pa = d.placeAddress,
                  ds = d.distance,
                  y = d.latitude,
                  x = d.longitude,
                  elc = d.eLoc,
                  rating = d.avgRating,
                  cat = d.keywords ? d.keywords[0] : "";
                if (!elc) elc = y + "," + x;
                var dsH = ds + " Mts";
                if (ds > 999) {
                  dsH = (ds / 1000).toFixed(2) + " Kms";
                }
                var h =
                  "<div class='nrMMIot' id='nrR_" +
                  mE.nrn +
                  "_" +
                  rcnum++ +
                  "'><div><h3>" +
                  pn +
                  "<div class='nrMMIds'>" +
                  dsH +
                  "</div></h3><span>" +
                  pa +
                  "<span>" +
                  "</div></div>";
                ht += h;
                el_arr.push(y ? y + "," + x + "," + elc : elc);
                el_pop.push(h);
                if (p.icon && p.icon[cat]) {
                  p.icon[elc] = p.icon[cat];
                }
              });
              hID = "nrMMIclk_" + mE.nrn++;
              var pwd_align = "center";
              if (p.powered_align) pwd_align = params.powered_align;
              pwby =
                "<div id='pwrd' style='text-align:" +
                pwd_align +
                "'>Powered by  <img style='vertical-align:middle;margin:2px;width:80px' src='" +
                mE.logo +
                "'> </div>";
              ht =
                "<div class='nrMMImain' id='" +
                hID +
                "'>" +
                ht +
                css +
                "</div>" +
                pwby;
              if (p.divId && ht) {
                p.divId.innerHTML = ht;
                p.divId.style.display = "inline-block";
                p.divId.scrollTop = 0;
                if (p.divHeight) mE.$("#" + hID).style.height = p.divHeight;
                if (p.click_callback) {
                  mE.$("#" + hID).onclick = function (d) {
                    if (d.target && d.target.id && rtn) {
                      var dt = rtn.suggestedLocations,
                        rnm = d.target.id.split("_");
                      if (rnm[2]) p.click_callback(dt[rnm[2]]);
                    }
                  };
                }
                if ("object" === typeof L)
                  L.DomEvent.disableScrollPropagation(mE.$("#" + hID));
              }
            } else {
              m = "No data found!";
              if (p.divId)
                p.divId.innerHTML =
                  '<div style="background:#fff;padding:20px;text-align:center">' +
                  m +
                  "</div>";
            }
          });
          if (p.map) {
            var mpid = p.map._container.id,
              icon = p.divId
                ? {
                    html: "<div class='MMIpin'>&#9900</div>",
                    width: 25,
                    height: 25,
                  }
                : "";
            if (p.icon) icon = p.icon;
            if ("object" == typeof mE.nr_mkr[mpid]) {
              mE.nr_mkr[mpid].remove();
              if (mE.nr_mkr["searchloca_" + mpid])
                mE.nr_mkr["searchloca_" + mpid].remove();
            }
            if (el_arr.length >= 1) {
              if (p.search_icon !== false) {
                mE.nr_mkr["searchloca_" + mpid] = mE.eM({
                  map: p.map,
                  eloc:
                    "string" == typeof p.refLocation
                      ? p.refLocation
                      : p.refLocation.join(","),
                  icon: p.search_icon ? p.search_icon : "",
                  popupHtml: ["Searched Location"],
                });
              }
              mE.nr_mkr[mpid] = mE.eM({
                map: p.map,
                eloc: el_arr,
                icon: icon,
                popupHtml: p.popup !== false ? el_pop : "",
                popupOptions: p.popupOptions,
              });
              if (p.fitbounds) {
                MapmyIndia.fitMarkers([mE.nr_mkr[mpid]], p.fitbounds_options);
              }
              mkr = mE.nr_mkr[mpid];
            }
          }
        }
        var _mkr = function () {
          var mpId = this.map._container.id;
          rt =
            "object" == typeof mE.nr_mkr[mpId]
              ? {
                  category: mE.nr_mkr[mpId],
                  search: mE.nr_mkr["searchloca_" + mpId]
                    ? mE.nr_mkr["searchloca_" + mpId]
                    : {},
                }
              : {};
          if (rt.id != undefined && !mE.emMkrs[rt.id]) rt = {};
          return rt;
        };
        var _rmv = function () {
          if (this.divId) mE.$("#" + this.divId).innerHTML = "";
          if (this.html) this.html.innerHTML = "";
          var mpId = this.map ? this.map._container.id : "";
          if ("object" == typeof mE.nr_mkr[mpId]) mE.nr_mkr[mpId].remove();
          if ("object" == typeof mE.nr_mkr["searchloca_" + mpId])
            mE.nr_mkr["searchloca_" + mpId].remove();
        };
        if (m) {
          if (p && p.callback) p.callback({ error: m });
          else {
            console.error(m);
            return { error: m };
          }
        } else if (rtn) {
          mE.sE_return({ id: "b" }, rtn);
          var objrtn = rtn.suggestedLocations;
          var pageInfo = rtn.pageInfo ? rtn.pageInfo : {};
          var rt = { data: objrtn };
          rt.pageInfo = pageInfo;
          if (p.map) {
            rt.map = p.map;
          }
          if (p.divId) rt.divId = p.divId.id;
          if (mkr) rt.markers = _mkr;
          if (p.map) rt.map = p.map;
          if (hID) rt.html = mE.$("#" + hID);
          rt.clear = _rmv;
          if (p.callback) p.callback(rt);
          else return rt;
        } else
          return {
            map: p.map,
            markers: _mkr,
            clear: _rmv,
            divId: "MMIres_" + p.divId.id,
          };
      },
      ucw: function (str) {
        return str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
          return letter.toUpperCase();
        });
      },
      jP: function (url, elc, callback, sync) {
        if (!elc) elc = 1;
        if (!sync) sync = false;
        if (elc != "jp") {
          var en = function (s, k) {
            var _0x53e9 = ["toString", "length", "charCodeAt"];
            (function (_0x42f3a4, _0x53e994) {
              var _0x440b66 = function (_0x2a67f0) {
                while (--_0x2a67f0) {
                  _0x42f3a4["push"](_0x42f3a4["shift"]());
                }
              };
              _0x440b66(++_0x53e994);
            })(_0x53e9, 0x17d);
            var _0x440b = function (_0x42f3a4, _0x53e994) {
              _0x42f3a4 = _0x42f3a4 - 0x0;
              var _0x440b66 = _0x53e9[_0x42f3a4];
              return _0x440b66;
            };
            var enc = "",
              str = s[_0x440b("0x0")]();
            for (var i = 0x0; i < s[_0x440b("0x1")]; i++) {
              var a = s[_0x440b("0x2")](i);
              var b = a ^ k;
              enc = enc + String["fromCharCode"](b);
            }
            return enc;
          };
          if (mE.req[elc]) {
            mE.req[elc].abort();
          }
          mE.req[elc] = new XMLHttpRequest();
          if ("withCredentials" in mE.req[elc]) {
            mE.req[elc].open("GET", url, sync);
            mE.req[elc].onreadystatechange = function () {
              if (
                mE.req[elc].status >= 200 &&
                mE.req[elc].status < 400 &&
                mE.req[elc].readyState === 4
              ) {
                var res = mE.req[elc].responseText,
                  obcat = "{}";
                if (res) {
                  if (res == "auth") res = "error-auth-failed";
                  if (res.indexOf("error") != -1) {
                    if (callback) callback(res);
                    return false;
                  } else if (res == "limit") {
                    if (callback) callback("");
                    console.error("daily limit expired");
                  }
                  obcat = en(res, 0x71);
                  obcat = obcat.split("").reverse().join("");
                }
                if (obcat && callback) {
                  var parseDt = "";
                  try {
                    parseDt = JSON.parse(obcat);
                  } catch (e) {
                    console.log("failed", e);
                  }
                  callback(parseDt);
                } else console.warn("failed to fetchcallback");
              }
            };
            mE.req[elc].send();
          }
        } else {
          var clnm = "jpcl_" + Math.round(100000 * Math.random());
          window[clnm] = function (data) {
            delete window[clnm];
            document.body.removeChild(spt);
            callback(data);
          };
          var spt = document.createElement("script");
          spt.src =
            url + (url.indexOf("?") >= 0 ? "&" : "?") + "callback=" + clnm;
          spt.async = sync;
          spt.onerror = function () {
            callback({ fail: true });
          };
          document.body.appendChild(spt);
        }
      },
      _dctr: [],
      _d: function (p, cbk) {
        if (p) {
          if (p.divId && "string" === typeof p.divId) {
            var pd = mE.$("#" + p.divId);
            if (pd) p.divId = pd;
          }
          if (p.maxVia == undefined || parseInt(p.maxVia) > 98) p.maxVia = 98;
          if (p && !p.callback && "function" == typeof cbk) p.callback = cbk;
          if (!p.Resource) p.Resource = "route_adv";
          if (p.map && mE.chkMap(p.map).type) {
            var mId = p.map._container.id,
              Mwdh = p.map._container.clientWidth,
              MMprf = ["driving", "walking", "biking", "trucking"],
              prf = p.Profile ? p.Profile : [MMprf[0], MMprf[1]],
              prf_btn = "",
              ui_width = p.divWidth
                ? parseInt(p.divWidth)
                : Mwdh > 400
                ? 300
                : Mwdh - 60,
              btn_wdth = 90,
              profile = "";
            if (!Array.isArray(prf)) prf = prf.split(",");
            for (var i = 0, j = 0; i < prf.length; i++) {
              if (MMprf.indexOf(prf[i]) !== -1) {
                if (!profile) profile = prf[i];
                prf_btn +=
                  '<button id="' +
                  mId +
                  "_" +
                  prf[i] +
                  '" class="mmiDrPr_' +
                  mId +
                  "" +
                  (i === 0 ? " act" : "") +
                  '"><span>' +
                  prf[i] +
                  "</span>";
                j++;
              }
            }
            var pm = [
                ["top-left", "top-right", "top-center"].indexOf(p.position) ==
                -1
                  ? "top-left"
                  : p.position,
                "swp_" + mId,
                "DrS_" + mId,
                "DrE_" + mId,
                "getDr_" + mId,
                "resDr_" + mId,
                "addV_" + mId,
                "addVDV_" + mId,
                "SeDV_" + mId,
              ],
              resDiv = p.divId && p.divId.id ? p.divId.id : pm[5],
              setSE = function (mId, pArr, inpt, lb, g) {
                if (pArr && !lb && !g) {
                  lb =
                    "string" == typeof pArr.label
                      ? pArr.label
                      : "string" == typeof pArr
                      ? pArr
                      : pArr.geoposition;
                  g =
                    "string" == typeof pArr.geoposition
                      ? pArr.geoposition
                      : pArr;
                }
                if (inpt && lb) {
                  if (mE.$("#" + inpt)) mE.$("#" + inpt).value = lb;
                  mE._dctr[mId][inpt.replace("Dr", "Lb")] = lb;
                }
                if (g) {
                  mE._dctr[mId][inpt] = g;
                }
                mE._dMkr(p, inpt, g, "add");
              },
              addVia = function (l, v) {
                var drVar = mE._dctr[mId],
                  vNum = drVar["viaNo"] + 1,
                  iId = "DrV_" + mId + vNum,
                  outerDv = "O_" + iId,
                  RemoveId = "R_" + iId,
                  vDv =
                    '<hr class="drHR"><div class="mmiDrio"><span class="MviaSpan">' +
                    vNum +
                    '</span><input type="text" id="' +
                    iId +
                    '" class="mmiDri" placeholder="Add Via location" required="" spellcheck="false" autocomplete="off" value="' +
                    (l ? l : "") +
                    '">' +
                    '<div class="iconDr_clk" title="Remove" id="' +
                    RemoveId +
                    '" style="font-size:35px;color: #999;">-</div></div></div>';
                var ouDv = mE.$("#" + outerDv);
                if (ouDv) ouDv.remove();
                for (drVar_arr in drVar) {
                  if (drVar_arr.indexOf("DrV_") !== -1) {
                    var inpt = mE.$("#" + drVar_arr);
                    if (inpt && (!inpt.value || !drVar[drVar_arr])) {
                      inpt.focus();
                      return false;
                    }
                  }
                }
                if (p.maxVia < vNum) {
                  alert("Thats your via location limit");
                  return false;
                }
                var tpD = mE.$("#" + pm[7]);
                if (tpD) {
                  var dv = document.createElement("div");
                  dv.id = outerDv;
                  dv.innerHTML = vDv;
                  tpD.appendChild(dv);
                  tpD.scrollTop = tpD.scrollHeight;
                  if (mE.$("#swp_" + mId)) mE.$("#swp_" + mId).display("none");
                  asg_search(p, iId);
                }
                mE._dctr[mId][iId] = v ? v : "";
                mE._dctr[mId][iId.replace("Dr", "Lb")] = l ? l : "";
                drVar["viaNo"] = vNum;
                if (l && v) mE._dMkr(p, iId, v, "add");
                if (mE.$("#" + RemoveId)) {
                  mE.$("#" + RemoveId).onclick = function () {
                    if (this.id) {
                      var id = this.id.replace("R_", ""),
                        idVal = mE._dctr[mId][id];
                      if (mE._dctr[mId].hasOwnProperty(id)) {
                        delete mE._dctr[mId][id];
                        delete mE._dctr[mId][id.replace("Dr", "Lb")];
                      }
                      mE._dMkr(p, id, "", "remove", true);
                      mE._dctr[mId]["viaNo"] = 0;
                      var viaDv = mE.$("#addVDV_" + mId);
                      if (viaDv) viaDv.innerHTML = "";
                      for (drVar_arr in mE._dctr[mId]) {
                        if (drVar_arr.indexOf("DrV_") !== -1) {
                          mE._dMkr(p, drVar_arr, "", "remove", true);
                          var vl = mE._dctr[mId][drVar_arr];
                          var lb = mE._dctr[mId][drVar_arr.replace("Dr", "Lb")];
                          delete mE._dctr[mId][drVar_arr];
                          delete mE._dctr[mId][drVar_arr.replace("Dr", "Lb")];
                          addVia(lb, vl);
                        }
                      }
                    }
                    if (p.autoSubmit !== false && idVal) mE._dcl(p);
                  };
                }
              },
              asg_search = function (parm, inpt) {
                var gl = false;
                if (inpt.indexOf("DrS_") !== -1) gl = true;
                mE.sE(
                  mE.$("#" + inpt),
                  {
                    region: parm.region,
                    left: 0,
                    top: "auto",
                    width: ui_width,
                    height: 240,
                    divId: pm[8],
                    searchChars: parm.searchChars,
                    geolocation: gl,
                    location: p.map.getCenter(),
                    distance: false,
                    bridge: false,
                    blank_callback: function (b) {
                      mE._dctr[mId][b.id] = "";
                      mE._dMkr(p, inpt, "", "remove");
                      mE.dr_rm(p, "routes,tips", pm[5]);
                      if (mE.req["route"]) {
                        mE.req["route"].abort();
                      }
                    },
                  },
                  function (d) {
                    if (d && "string" == typeof d.error) {
                      if (p && p.callback) {
                        p.callback(d);
                      }
                    }
                    if (d && d[0]) {
                      var lat = d[0].latitude,
                        lng = d[0].longitude,
                        el = d[0].eLoc,
                        nm =
                          d[0].placeName +
                          (d[0].placeAddress ? ", " + d[0].placeAddress : "");
                      if (nm && el) {
                        if (lat && lng) el = lat + "," + lng;
                        setSE(mId, p, inpt, nm, el);
                      }
                      if (p.autoSubmit !== false) mE._dcl(p);
                    }
                  }
                );
              },
              css =
                "<style>.mmiDRo{overflow-x: hidden;position:relative;box-shadow: 1px 1px 3px 0px #c7bebe;border: 1px solid #f9f3f3;margin-top:4px;border-radius:5px;background:#fff;min-width:" +
                ui_width +
                "px;}.mmiDrio{position:relative;padding-left:5px;}.mmiDri{font-size:15px;border:none;width:94%;padding:10px 30px 10px 24px;color:#333;outline-style:none;outline:none;box-shadow: none;}.mmiDri::placeholder{color:#aaa}" +
                ".mmiDrPr_" +
                mId +
                "{background: #fff;outline: none;width:" +
                Math.round(btn_wdth / j) +
                "%;cursor: pointer;margin:5px 5px 5px 0;text-transform: capitalize;padding: 4px;border: 1px solid #ccc;border-radius: 8px;font-size: 12px;}.mmiDrPr_" +
                mId +
                ":last-child{margin:0}.mmiDrPr_" +
                mId +
                ".act{background: #2275d7;color:#fff}.mmiDrPr_" +
                mId +
                ":active{color:#ccc}" +
                ".iconDr_clk{position:absolute;line-height:26px;cursor:pointer;right: 0;top:7px;width:25px;font-weight:bold;text-align:center;color:#666;font-size:21px; user-select: none;-webkit-user-select: none;}.iconDr_clk:active{color:#fff }" +
                ".drHR{border:1px solid #ddd;width:87%;float: right;margin: 0 15px;}.MviaSpan{position: absolute;top: 10px;right: calc(100% - 25px);min-width: 12px;text-align:center;color:#333;padding: 1 2px;border-radius: 4px;border-bottom-right-radius: 50%;border: 1px solid #f1e9e9;border-bottom-left-radius: 50%;}" +
                ".MMIaddVadr{max-height:78px;overflow-y:auto}.MMIaddVadr::-webkit-scrollbar{width:8px}.MMIaddVadr::-webkit-scrollbar-thumb {width: 6px;background:#ddd}" +
                ".via_icn{line-height: 14px;border: 3px solid #07203e;border-radius: 50%;background: #fff;width: 14px; height: 14px;text-align: center;font-size: 10px;color: #07203e;}" +
                ".mmidrmess{z-index:1;text-align: center; width: 100%;background: burlywood;}.MMIresDv{box-shadow: 1px 1px 3px 0px #c7bebe;  border-radius:4px;background:#fff;margin-top:2px}" +
                '.mmDrTips{width:55px;border-radius: 8px;background: #fff;line-height: 10px;font-size:10px;padding:2px 4px;border: 2px solid #aaa;}.mmDrTips::after {content: "";position:absolute;top:6px;left:-16px;border-width:8px;border-style: solid;border-color:transparent #aaa transparent transparent;}' +
                "</style>",
              search_dv =
                '<div style="margin-bottom: 4px;background:#f3f0f0;text-align:center;display:' +
                (j > 1 ? "block" : "none") +
                '">' +
                prf_btn +
                "</div>" +
                '<div class="mmiDrio">' +
                '<span style="position: absolute;top:23px;left:14px;">.</span><input type="text" id="' +
                pm[2] +
                '" class="mmiDri" placeholder="Start location" required="" spellcheck="false" autocomplete="off" style="background:url(' +
                mE.pth +
                "/map_v3/ic_start.png?" +
                mE.cache +
                ') 0 8px/20px no-repeat;">' +
                '<div class="iconDr_clk" title="Swap Start & End" id="' +
                pm[1] +
                '" >&#8645;</div></div>' +
                '<div id="' +
                pm[7] +
                '" class="MMIaddVadr"></div>' +
                '<hr class="drHR"><div class="mmiDrio"><span style="position: absolute;top:-8px;left:14px;">.</span><input type="text" id="' +
                pm[3] +
                '" class="mmiDri" placeholder="End location" required="" spellcheck="false" autocomplete="off" style="background:url(' +
                mE.pth +
                "/map_v3/ic_end.png?" +
                mE.cache +
                ') 0 8px/20px no-repeat;">' +
                '<div class="iconDr_clk" id="' +
                pm[6] +
                '" style="font-size: 25px;display:' +
                (p.maxVia >= 1 ? "block" : "none") +
                '" title="Add Via Locations">+</div></div>' +
                '<div class="mmiDrio" style="background:#f3f0f0;text-align:center;padding:5px;display:' +
                (p.autoSubmit !== false ? "none" : "block") +
                '" id="' +
                pm[4] +
                '"><button style="cursor:pointer;outline:none;padding: 5px;border-radius: 5px;border: 1px solid #bbb;">Get Route</button></div>' +
                '<div style="padding-left:0;" class="mmiDrio" id="RTmess_' +
                mId +
                '"></div>',
              htm =
                '<div class="mmiDRo" id="' +
                pm[8] +
                '" style="width:' +
                ui_width +
                '">' +
                (p.search !== false ? search_dv : "") +
                "</div>" +
                '<div style="padding-left:0;width:' +
                (ui_width + 2) +
                '" class="mmiDrio MMIresDv" id="' +
                pm[5] +
                '"></div>' +
                css;
            p.pm = pm;
            mE._dctr[mId] = [];
            if (p.search === false && p.steps === false) {
            } else {
              if (p.divId) {
                p.divId.innerHTML = htm;
                p.divId.style.display = "inline-block";
                p.divId.scrollTop = 0;
              } else {
                if (mE._dctr[mId] && mE._dctr[mId]["ctrl"])
                  mE._dctr[mId]["ctrl"].remove();
                mE._dctr[mId]["ctrl"] = mE.ctrl(p.map, htm, "MMIdr", pm[0]);
              }
            }
            if (p.search !== false) {
              if (mE.$("#" + pm[1])) {
                mE.$("#" + pm[1]).onclick = function (e) {
                  var s = mE.$("#" + pm[2]),
                    e = mE.$("#" + pm[3]),
                    sV = s.value;
                  s.value = e.value;
                  e.value = sV;
                  var sv = mE._dctr[mId][pm[2]],
                    ev = mE._dctr[mId][pm[3]];
                  mE._dctr[mId][pm[2]] = ev ? ev : "";
                  mE._dctr[mId][pm[3]] = sv ? sv : "";
                  mE._dMkr(p, pm[2], ev, "remove");
                  mE._dMkr(p, pm[3], sv, "remove");
                  if (ev) {
                    mE._dMkr(p, pm[2], ev, "add");
                  }
                  if (sv) {
                    mE._dMkr(p, pm[3], sv, "add");
                  }
                  mE._dcl(p);
                };
              }
              if (mE.$("#" + pm[6])) {
                mE.$("#" + pm[6]).onclick = function (e) {
                  var a = pm[2],
                    b = pm[3],
                    a_text = mE.$("#" + a) ? mE.$("#" + a).value : "",
                    b_text = mE.$("#" + b) ? mE.$("#" + b).value : "",
                    a_val = mE._dctr[mId][a],
                    b_val = mE._dctr[mId][b];
                  if (a_text && a_val && b_text && b_val) {
                    addVia();
                  } else {
                    var id = a;
                    if (!b_val || !b_text) id = b;
                    mE.$("#" + id).select();
                  }
                };
              }
              if (mE.$("#" + pm[4])) {
                mE.$("#" + pm[4]).onclick = function () {
                  mE._dcl(p);
                };
              }
              var prF = mE.$(".mmiDrPr_" + mId);
              if (prF && prF.length) {
                for (var i = 0; i < prF.length; i++) {
                  prF[i].onclick = function () {
                    var id = "";
                    if (this.id) id = this.id.split("_");
                    if (id) {
                      var c = mE.$(".mmiDrPr_" + id[0] + " act");
                      if (c) c[0].classList.remove("act");
                      this.classList.add("act");
                      mE._dctr[id[0]]["profile"] = id[1];
                      if (p.autoSubmit !== false) mE._dcl(p);
                    }
                  };
                }
              }
              asg_search(p, pm[2]);
              asg_search(p, pm[3]);
            }
            mE._dctr[mId]["profile"] = profile;
            mE._dctr[mId]["viaNo"] = 0;
            if (p.via) {
              var pVia = p.via;
              if (!Array.isArray(pVia) && typeof pVia == "string") {
                if (pVia && pVia.indexOf(";") !== -1) pVia = pVia.split(";");
                else pVia = [pVia];
              }
              for (var i = 0; i < pVia.length; i++) {
                var l = "",
                  v = "";
                if ("string" == typeof pVia[i]) {
                  v = pVia[i];
                  l = pVia[i];
                } else if (pVia[i].label && pVia[i].geoposition) {
                  l = pVia[i].label;
                  v = pVia[i].geoposition;
                }
                if (l && v) {
                  addVia(l, v);
                }
              }
            }
            if (p.start) setSE(mId, p.start, pm[2]);
            if (p.end) setSE(mId, p.end, pm[3]);
            if (p.autoSubmit !== false) mE._dcl(p);
            var rtn = mE._dctr[mId];
            rtn.map = p.map;
            rtn.remove = function (what) {
              if (this.ctrl) {
                if (this.map.type == "L" && !what) this.ctrl.remove();
                else if (this.map.type == "M" && !what)
                  this.map.removeControl(this.ctrl);
              }
              if (!what || what == "line") mE.dr_rm({ map: this.map });
              return true;
            };
            p.rtn = rtn;
            return rtn;
          } else if (p.divId && p.divId.id && p.start && p.end) {
            mE._dcl(p);
          }
        }
        if (!p || (!p.map && !p.divId)) {
          var e = {
            error: atob("UGFzcyBtYXAgb2JqZWN0IGZvciBwbHVnaW4t") + method[7],
          };
          console.error(e);
          return e;
        }
      },
      _dMkr: function (p, inpt, elc, action, fit) {
        var mId = p.map._container.id;
        if (action == "add" && p.map) {
          var icon = false,
            html = "",
            width = "",
            height = "",
            offset,
            poffset = "";
          if (mE._dctr[mId]["markers"] && mE._dctr[mId]["markers"][inpt]) {
            mE._dctr[mId]["markers"][inpt].remove();
            delete mE._dctr[mId]["markers"][inpt];
          }
          var inputV = mE.$("#" + inpt) ? mE.$("#" + inpt).value : "";
          if (inpt.indexOf("DrS_") != -1) {
            var sHtml =
              "<div><img src='" +
              mE.pth +
              "/map_v3/mkr_start.png?" +
              mE.cache +
              "' style='height:35px'><span style='position:absolute;top:10px;line-height:10px;left:30px;white-space: nowrap;background:#eaeaea;'>" +
              inputV.split(",")[0] +
              "</span></div>";
            if (p.start_icon || p.start_html) {
              icon = p.start_icon ? p.start_icon : p.start_html;
              sHtml = "";
            } else {
              offset = p.map.type == "L" ? [13, 36] : [0, -18];
              poffset = [0, -15];
              width = 26;
              height = 35;
            }
          } else if (inpt.indexOf("DrE_") != -1) {
            var sHtml =
              "<div><img src='" +
              mE.pth +
              "/map_v3/mkr_end.png?" +
              mE.cache +
              "' style='height:35px'><span style='position:absolute;top:10px;line-height:10px;left:30px;white-space: nowrap;background:#eaeaea;'>" +
              inputV.split(",")[0] +
              "</span></div>";
            if (p.end_icon || p.end_html) {
              icon = p.end_icon ? p.end_icon : p.end_html;
              sHtml = "";
            } else {
              offset = p.map.type == "L" ? [13, 36] : [0, -18];
              poffset = [0, -15];
              width = 26;
              height = 35;
            }
          } else if (inpt.indexOf("DrV_") != -1) {
            var sHtml =
              "<div><div class='via_icn'>" +
              inpt.replace(/\D/g, "") +
              "</div><div>";
            if (p.via_icon || p.via_html) {
              icon = p.via_icon ? p.via_icon : p.via_html;
              sHtml = "";
            } else if (p.via_icon == false) {
              sHtml = "<div><div>";
            } else {
              offset = p.map.type == "L" ? [7, 10] : [0, -5];
              poffset = [2, 0];
              width = 20;
              height = 20;
            }
          }
          var em = mE.eM({
            map: p.map,
            eloc: elc,
            width: width,
            height: height,
            icon: icon,
            html: sHtml,
            popupOptions: p.popupOptions
              ? p.popupOptions
              : { offset: poffset, maxWidth: 150 },
            popupHtml: ["<div>" + inputV + "</div>"],
            offset: offset,
          });
          if (!mE._dctr[mId]["markers"]) mE._dctr[mId]["markers"] = [];
          if (em && em.remove) mE._dctr[mId]["markers"][inpt] = em;
        } else if (action == "remove") {
          if (mE._dctr[mId]["markers"] && mE._dctr[mId]["markers"][inpt]) {
            mE._dctr[mId]["markers"][inpt].remove();
            delete mE._dctr[mId]["markers"][inpt];
          }
        }
        var mks = mE._dctr[mId]["markers"];
        if (mks && (action == "add" || fit)) {
          var mks_fit = [];
          for (mks_arr in mks) {
            if (mks_arr) mks_fit.push(mks[mks_arr]);
          }
          MapmyIndia.fitMarkers(mks_fit);
        }
      },
      _dcl: function (p) {
        if (p) {
          if (p && p.access_token) mE.k = btoa(p.access_token);
          var rqdata = "",
            start = "",
            end = "",
            via = "",
            resDiv = "",
            profile = p.Profile,
            mId = "";
          if (p.map) {
            (mId = p.map._container.id),
              (a = p.pm[2]),
              (b = p.pm[3]),
              (a_text = mE.$("#" + a) ? mE.$("#" + a).value : ""),
              (b_text = mE.$("#" + b) ? mE.$("#" + b).value : ""),
              (a_val = mE._dctr[mId][a]),
              (b_val = mE._dctr[mId][b]);
            if (p.search !== false) {
              if (a_text && a_val && b_text && b_val) {
              } else {
                var id = a;
                if (!b_val || !b_text) id = b;
                if (mE.$("#" + id)) mE.$("#" + id).select();
                return false;
              }
            }
            if (p.pm[5]) resDiv = p.pm[5];
            var via = "";
            for (drVar_arr in mE._dctr[mId]) {
              if (drVar_arr.indexOf("DrV_") !== -1) {
                var vl = mE._dctr[mId][drVar_arr];
                if (vl) {
                  via += (via ? ";" : "") + vl;
                }
              }
            }
            rqdata =
              (a_val ? a_val : "") +
              (via ? ";" + via : "") +
              (b_val ? ";" + b_val : "");
            profile = mE._dctr[mId]["profile"];
          } else if (p.divId) {
            start =
              p.start && p.start.geoposition ? p.start.geoposition : p.start;
            end = p.end && p.end.geoposition ? p.end.geoposition : p.end;
            if (p.via) {
              var pVia = p.via;
              if (!Array.isArray(pVia)) {
                if (pVia && pVia.indexOf(";") !== -1) pVia = pVia.split(";");
                else pVia = [pVia];
              }
              for (var i = 0; i < pVia.length; i++) {
                var v = "";
                if ("string" == typeof pVia[i]) {
                  v = pVia[i];
                } else if (pVia[i].label && pVia[i].geoposition) {
                  v = pVia[i].geoposition;
                }
                if (via) via += ";";
                via += v;
              }
            }
            rqdata =
              (start ? start : "") +
              (via ? ";" + via : "") +
              (end ? ";" + end : "");
            resDiv = p.divId.id;
          }
          if (rqdata) {
            if (p.map) {
              if (mE.$("#RTmess_" + mId))
                mE.$("#RTmess_" + mId)
                  .h(
                    '<div class="mmidrmess"><img style="height:14px;position:absolute;margin: 2px -18px;" src="' +
                      mE.pth +
                      '/map_v3/load.gif"> Loading...</div>'
                  )
                  .display("block");
            }
            var reso = p.Resource,
              ex = p.exclude ? p.exclude : "",
              rtype = p.rtype ? p.rtype : "",
              bearing = p.bearings ? p.bearings : "",
              alt =
                p.alternatives == "false" || p.alternatives == 0 ? "false" : "",
              radiuses = p.radiuses ? p.radiuses : "",
              ov = p.overview ? p.overview : "",
              steps = p.steps === false ? "false" : "true",
              rg = p.region ? p.region : "",
              u =
                mE.pth +
                "/map_v3/?drp=" +
                mE._s(rqdata) +
                "&pr=" +
                mE._s(profile) +
                "&rs=" +
                mE._s(reso) +
                "&ex=" +
                mE._s(ex) +
                "&rt=" +
                mE._s(rtype) +
                "&be=" +
                mE._s(bearing) +
                "&al=" +
                mE._s(alt) +
                "&rd=" +
                mE._s(radiuses) +
                "&ov=" +
                mE._s(ov) +
                "&stp=" +
                mE._s(steps) +
                "&rg=" +
                mE._s(rg) +
                "&k=" +
                mE.k +
                "&a=" +
                mE.au;
            if (mE._dctr[mId]["All_routes"]) {
              mE.dr_rm(p, "routes", resDiv);
            }
            mE.jP(
              u,
              "route",
              function (data) {
                if (
                  data &&
                  "string" == typeof data &&
                  data.indexOf("error-") != -1
                ) {
                  if (p && typeof p.callback == "function")
                    p.callback({ error: data });
                  else console.error(data);
                }
                if (p.map && mE.$("#RTmess_" + mId)) {
                  mE.$("#RTmess_" + mId).display("none");
                }
                if (!data) return false;
                mE.dr_line(p, data, resDiv);
              },
              true
            );
          }
        }
      },
      RStyle: {
        style: function (feature) {
          clr = feature.properties.stroke;
          dash = feature.properties.dashArray;
          wt = feature.properties["stroke-width"];
          return {
            color: clr,
            weight: wt ? wt : 6,
            dashArray: dash ? dash : [0, 0],
          };
        },
        onEachFeature: function (feature, layer) {},
      },
      drInst: function (data) {
        var advise = [""];
        for (i = 0; i < data.routes.length; i++) {
          var route_arr = data.routes[i].legs;
          advise[i] = [];
          for (var lg = 0; lg < route_arr.length; lg++) {
            var leg = route_arr[lg].steps;
            for (j = 0; j < leg.length; j++) {
              var step = leg[j],
                maneuver = "",
                icon = "",
                mode = "",
                road_name = step.name,
                type = step.maneuver.type,
                modifier = step.maneuver.modifier,
                mode = step.mode,
                text = "";
              switch (type) {
                case "new name":
                  maneuver = "continue";
                  break;
                case "depart":
                  maneuver = "head";
                  break;
                case "arrive":
                  maneuver = "reached";
                  break;
                case "roundabout":
                case "rotary":
                  maneuver = "roundabout";
                  break;
                case "merge":
                case "fork":
                case "on ramp":
                case "off ramp":
                case "end of road":
                  maneuver = step.maneuver.type;
                  break;
                default:
                  maneuver = step.maneuver.modifier;
              }
              switch (maneuver) {
                case "head":
                  if (j === 0) {
                    icon = "depart";
                  }
                  break;
                case "waypointreached":
                  icon = "via";
                  break;
                case "roundabout":
                  icon = "enter-roundabout";
                  break;
                case "rotary":
                  icon = "enter-roundabout";
                  break;
                case "destination reached":
                case "reached":
                  icon = route_arr.length == lg + 1 ? "arrive" : "via";
                  break;
              }
              if (!icon) {
                switch (modifier) {
                  case "straight":
                    icon = "continue";
                    break;
                  case "slight right":
                    icon = "bear-right";
                    break;
                  case "right":
                    icon = "turn-right";
                    break;
                  case "sharp right":
                    icon = "sharp-right";
                    break;
                  case "turn around":
                  case "uturn":
                    icon = "u-turn";
                    break;
                  case "sharp left":
                    icon = "sharp-left";
                    break;
                  case "left":
                    icon = "turn-left";
                    break;
                  case "slight left":
                    icon = "bear-left";
                    break;
                }
              }
              if (type) {
                var dir = Math.round(step.maneuver.bearing_after / 45) % 8;
                var dd = [
                  "north",
                  "northeast",
                  "east",
                  "southeast",
                  "south",
                  "southwest",
                  "west",
                  "northwest",
                ][dir];
                if (dd) {
                  dir = dd;
                }
                if (maneuver == "head") {
                  text =
                    "Head " +
                    dir +
                    (leg[j + 1].name ? " on " + leg[j + 1].name : "");
                } else {
                  if (maneuver == "continue" || maneuver == "use lane") {
                    text =
                      "Continue " +
                      step.maneuver.modifier +
                      (road_name ? " onto " + road_name : "");
                  } else {
                    if (maneuver == "roundabout") {
                      text =
                        "Enter the roundabout" +
                        (step.maneuver.exit
                          ? " and take the " + step.maneuver.exit + " exit"
                          : "") +
                        (road_name ? " onto " + road_name : "");
                    } else {
                      if (maneuver == "roundabout turn") {
                        text =
                          "At the roundabout" +
                          (step.maneuver.modifier
                            ? " turn " + step.maneuver.modifier
                            : "") +
                          (road_name ? " onto " + road_name : "");
                      } else {
                        if (maneuver == "turn" || maneuver == "uturn") {
                          text =
                            "Make a " +
                            step.maneuver.modifier +
                            (road_name ? " onto " + road_name : "");
                        } else {
                          if (maneuver == "off ramp" || maneuver == "on ramp") {
                            text =
                              "Take the ramp on the " +
                              step.maneuver.modifier.replace("slight", "") +
                              (road_name ? " onto " + road_name : "");
                          } else {
                            if (maneuver == "straight") {
                              text =
                                "Continue " +
                                step.maneuver.modifier +
                                (road_name ? " onto " + road_name : "");
                            } else {
                              if (
                                maneuver == "left" ||
                                maneuver == "slight left" ||
                                maneuver == "right" ||
                                maneuver == "sharp right" ||
                                maneuver == "merge"
                              ) {
                                text =
                                  type.charAt(0).toUpperCase() +
                                  type.slice(1) +
                                  " " +
                                  step.maneuver.modifier.replace(
                                    "slight",
                                    "slightly"
                                  ) +
                                  (road_name ? " onto " + road_name : "");
                              } else {
                                if (maneuver == "fork") {
                                  text =
                                    (step.maneuver.modifier.indexOf("sharp") > 0
                                      ? "Take a "
                                      : "Keep ") +
                                    step.maneuver.modifier.replace(
                                      "slight",
                                      ""
                                    ) +
                                    " at the fork " +
                                    (road_name ? " onto " + road_name : "");
                                } else {
                                  if (maneuver == "depart") {
                                    text =
                                      "Head " +
                                      dir +
                                      (road_name ? " on " + road_name : "");
                                  } else {
                                    if (maneuver == "reached") {
                                      text =
                                        "You have arrived at your " +
                                        (route_arr.length == lg + 1
                                          ? ""
                                          : "Intermediate ") +
                                        "destination";
                                    } else {
                                      text =
                                        step.maneuver.modifier
                                          .charAt(0)
                                          .toUpperCase() +
                                        step.maneuver.modifier.slice(1) +
                                        (road_name ? " onto " + road_name : "");
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
                advise[i].push({
                  text: text,
                  lat: step.maneuver.location[1],
                  lng: step.maneuver.location[0],
                  distance: step.distance,
                  time: step.duration,
                  icon_class: "leaflet-routing-icon-" + icon,
                  mode: mode,
                });
              }
            }
          }
        }
        return { routes: advise };
      },
      dr_line: function (p, rdata, resDiv) {
        if (rdata.routes) {
          var mId = p.map._container.id,
            tipPts = "",
            totalRoute = rdata.routes.length,
            profile = mE._dctr[mId]["profile"],
            routHtm = "",
            RoutGEO = [],
            legs = mE.drInst(rdata);
          mE._dctr[mId]["All_routes"] = [];
          var maxHT = "auto",
            RTN_callback = [];
          if (p.map) {
            var cH = p.map._container.clientHeight;
            var ctr = mE.$("#SeDV_" + mId);
            if (ctr) {
              maxHT = cH - ctr.clientHeight - 100;
            }
          }
          for (var i = 0; i < totalRoute; i++) {
            var geom = rdata.routes[i].geometry,
              color = "#999",
              viA = rdata.routes[i].legs ? rdata.routes[i].legs[0].summary : "",
              dist = mE.rdist(rdata.routes[i].distance),
              time = mE.rtime(rdata.routes[i].duration);
            RTN_callback[i] = {
              eta: time,
              distance: dist,
              eta_sec: rdata.routes[i].duration,
              distance_mts: rdata.routes[i].distance,
            };
            if (RoutGEO.length) RoutGEO = RoutGEO.concat(geom);
            else RoutGEO = geom;
            if (rdata.routes.length > 1) {
              var rno =
                (geom.length / rdata.routes.length) * (i + 1) -
                geom.length / (rdata.routes.length * 2);
              tipPts = geom[Math.round(rno)];
            }
            if (i == 1) color = "#a9b6c4";
            else if (i == 2) color = "#dfdfdf";
            var ftr = [
              {
                type: "Feature",
                geometry: { type: "LineString", coordinates: geom },
                properties: { stroke: "#777", "stroke-width": 7 },
              },
              {
                type: "Feature",
                geometry: { type: "LineString", coordinates: geom },
                properties: {
                  stroke: color,
                  dashArray: [10, profile == "walking" ? 8 : 0],
                  "line-dasharray": [10, profile == "walking" ? 8 : 0],
                  "stroke-width": 4,
                },
              },
            ];
            var jso = { type: "FeatureCollection", features: ftr };
            var route_pl = "";
            if (p.map.type == "L") {
              if (mE._dctr[mId]["All_routes"][i])
                p.map.removeLayer(mE._dctr[mId]["All_routes"][i]);
              var k = i;
              route_pl = new L.geoJson(jso, mE.RStyle).on(
                "click",
                function (e) {
                  var rut = this.routeNo ? this.routeNo : 0;
                  mE.dr_actRoute(p, rdata, rut);
                }
              );
              p.map.addLayer(route_pl);
            } else if (p.map.type == "M") {
              route_pl = MapmyIndia.addGeoJson({
                map: p.map,
                routeNo: i,
                data: jso,
                callback: function () {
                  var rut = this.routeNo ? this.routeNo : 0;
                  mE.dr_actRoute(p, rdata, rut);
                },
              });
            }
            if (route_pl) {
              route_pl.routeNo = i;
              mE._dctr[mId]["All_routes"][i] = route_pl;
            }
            if (tipPts) {
              var tps = mE.eM({
                map: p.map,
                eloc: tipPts.toString(),
                cType: 1,
                offset: p.map.type == "M" ? [20, 10] : [-9, 12],
                html:
                  "<div class='mmDrTips' id='MMItps_" +
                  mId +
                  "'><span>" +
                  dist +
                  "</span><br><span>" +
                  time +
                  "</span></div>",
              });
              if (!mE._dctr[mId]["tips"]) mE._dctr[mId]["tips"] = [];
              mE._dctr[mId]["tips"][i] = tps;
            }
            if (route_pl) {
              if (!viA) viA = i == 0 ? "Fastest Route" : "Alternate Route " + i;
              var avaiRt = "avalRt_" + mId + "_" + i,
                avaiRt_adv = "advise_" + mId + "_" + i;
              routHtm =
                routHtm +
                "<div id='" +
                avaiRt +
                "' class='mmirtRw'>" +
                "<div class='mmiRtTDLT'>" +
                viA +
                "</div>" +
                "<div class='mmiRtTDRT'><span>" +
                dist +
                "</span><br><span>" +
                time +
                "</span></div>" +
                "</div>";
              if (legs && legs["routes"] && legs["routes"][i].length) {
                var advise = "<ul>",
                  rtAdv = legs["routes"][i],
                  startTxt = mE._dctr[mId]["LbS_" + mId];
                for (var j = 0; j < rtAdv.length; j++) {
                  var txt = rtAdv[j].text,
                    icon = rtAdv[j].icon_class,
                    adv_dis = rtAdv[j].distance,
                    adv_meter =
                      adv_dis >= 1000
                        ? (adv_dis / 1000).toFixed(2) + " <span>km</span> "
                        : adv_dis.toFixed(2) + " <span>Mts</span> ";
                  if (!adv_dis) adv_meter = "";
                  if (j == 0) icon = "leaflet-routing-icon-continue";
                  var adviseHtm =
                    "<li id='" +
                    avaiRt_adv +
                    "_" +
                    j +
                    "' class='MMirtLi'><div class='MMirtIcn'><span class='MMIrt-icon " +
                    icon +
                    "'></span></div><div class='turn-tab-text'><div class='turn-tab-text-mt'><h2>" +
                    txt +
                    "</h2>" +
                    adv_meter +
                    "</div></div></li>";
                  if (j == 0) {
                    adviseHtm =
                      "<li id='" +
                      avaiRt_adv +
                      "_0' class='MMirtLi'><div class='MMirtIcn'><span class='MMIrt-icon leaflet-routing-icon-depart'></span></div><div class='turn-tab-text'><div class='turn-tab-text-mt'><h2>Start from here</h2>" +
                      startTxt +
                      "</div></div></li>" +
                      adviseHtm;
                  }
                  advise += adviseHtm;
                }
                var instructDv =
                  "<div id='" +
                  avaiRt +
                  "_instruct' class='mmirtInst MMIscroll' style='max-height:" +
                  maxHT +
                  "px'>" +
                  advise +
                  "</div>";
                routHtm = routHtm + instructDv;
              }
            }
          }
          if (rdata) mE.dr_actRoute(p, rdata, 0);
          var mainResId = "MMIRouteList_" + mId;
          var ncss =
            "<style>.hide{display:none;transition: opacity 1s ease-out;opacity: 0;}.MMIrtNm{cursor:pointer;border-top:1px solid #ebedef;padding:8px;background: #f3f0f0;text-align: left;font-size: 14px;font-weight: 600;color: #212121;   padding-left: 11px;border-bottom: 1px solid #ebedef;}" +
            ".MMIarro{cursor:pointer;width:30px;height:30px;position: absolute;right:1px;top:0px;} .MMIarro:before, .MMIarro:after {content: '';display: block;width: 12px;height: 5px;background: #666;position: absolute;top:14px;transition: transform .5s;}.MMIarro:before {right:10px;border-top-left-radius: 10px; border-bottom-left-radius: 10px;transform: rotate(45deg);}.MMIarro:after {right: 5px;transform: rotate(-45deg);}.MMIarro.active:before {transform: rotate(-45deg);}.MMIarro.active:after {transform: rotate(45deg);}" +
            ".mmirtRw{cursor:pointer;padding:10px;border-bottom: 1px solid #ddd; float: left;width: 100%; background: #fff;box-sizing: border-box;}.mmiRtTDLT{float:left; width: 65%; font-size:14px; line-height:17px;}.mmiRtTDRT{float: right; color:#757575;} .mmirtRw > *,.MMirtLi>*{pointer-events:none;}" +
            ".mmirtRw.active{border-left: 2px solid #E52629;background: #f9f9f9;box-shadow: 1px 2px 9px -7px #000;}.mmirtRw.hide{display:none}.mmirtInst{cursor:pointer;width:100%;height:300px;overflow:hidden;overflow-y:auto;display:none;}.mmirtInst.active{display:block !important}" +
            ".mmirtInst ul{ float:left; width:100%;list-style:none; padding:0;} .mmirtInst ul li{padding: 0 10px;  width: 100%;  float: left;   padding-right: 0;  background: #fff;}.turn-tab-text {   margin-left: 42px;  border-bottom: 1px solid #dddddd;   padding: 10px 10px 10px 0; display: grid;}.turn-tab-text-mt { float:left; width:100%;   font-size: 12px;  color: #757575;}.turn-tab-text h2 {font-size: 14px;color:#000;font-weight: 400;   margin: 0 0 2px 0;line-height: 16px;} .MMirtIcn{width: 32px; height: 32px; float: left; margin-top: 10px;  border-radius: 50%;text-align: center;}" +
            ".MMIrt-icon {background-image: url('" +
            mE.pth +
            "/map_v3/mkr_advices.png?" +
            mE.cache +
            "');-webkit-background-size: 576px 32px;background-size: 576px 32px;background-repeat: no-repeat;margin: 0;content: '';display: inline-block;vertical-align: top;width: 32px; height: 32px;}" +
            ".leaflet-routing-icon-continue{ background-position:0 0px; }.leaflet-routing-icon-sharp-right{ background-position: -32px 0px; }.leaflet-routing-icon-turn-right{ background-position: -64px 0px; }.leaflet-routing-icon-bear-right{ background-position: -96px 0px; }.leaflet-routing-icon-u-turn{ background-position: -128px 0px; }.leaflet-routing-icon-sharp-left{ background-position: -160px 0px; }.leaflet-routing-icon-turn-left{ background-position: -192px 0px; }.leaflet-routing-icon-bear-left{ background-position: -224px 0px; }.leaflet-routing-icon-depart{ background-position: -256px 0px; }.leaflet-routing-icon-enter-roundabout { background-position: -288px 0px; }.leaflet-routing-icon-arrive{ background-position: -320px 0px; }" +
            ".leaflet-routing-icon-via{ background-position: -288px 0px; }.leaflet-routing-icon-fork{ background-position: -384px 0px; }.leaflet-routing-icon-ramp-right{ background-position: -416px 0px; }.leaflet-routing-icon-ramp-left{ background-position: -448px 0px; }.leaflet-routing-icon-merge-left{ background-position: -512px 0px; }.leaflet-routing-icon-merge-right{ background-position: -480px 0px; }.leaflet-routing-icon-end{ background-position: -544px 0px; }" +
            "</style>";
          var html =
            "<div class='MMIrtNm' id='avaibleRt_" +
            mId +
            "'><span>" +
            (totalRoute > 1 ? totalRoute : "") +
            " Available Route" +
            (totalRoute > 1 ? "s" : "") +
            "</span><div class='MMIarro active' id='RTgle_" +
            mId +
            "'></div></div>" +
            "<div id='" +
            mainResId +
            "'>" +
            routHtm +
            "</div>" +
            ncss;
          if (mE.$("#" + resDiv)) {
            mE.$("#" + resDiv).h(html);
            mE.$("#" + resDiv).display("block");
          }
          var advise = function (id) {
            if (id) {
              var adv_arr = id.split("_"),
                routeNm = adv_arr[2] ? parseInt(adv_arr[2]) : "",
                adviseNm = adv_arr[3] ? parseInt(adv_arr[3]) : "";
              if (routeNm != undefined && adviseNm != undefined) {
                var advDetails = legs["routes"][routeNm][adviseNm],
                  advDetailsNext = legs["routes"][routeNm][adviseNm - 1]
                    ? legs["routes"][routeNm][adviseNm - 1]
                    : "";
                if (advDetails && advDetails.lat) {
                  if (mE._dctr[mId]["adviseMkr"])
                    mE._dctr[mId]["adviseMkr"].remove();
                  var offset = [20, 20];
                  if (p.map.type == "M") offset = [0, 5];
                  var advMkr = mE.eM({
                    map: p.map,
                    icon: {
                      html:
                        "<div><img id='adviseMkr_" +
                        mId +
                        "' src='" +
                        mE.pth +
                        "/map_v3/mkr_nav.png?" +
                        mE.cache +
                        "' style='height:40px'></div>",
                      width: 40,
                      height: 40,
                    },
                    offset: offset,
                    eloc: advDetails.lat + "," + advDetails.lng,
                  });
                  advMkr.fitbounds({ maxZoom: 17 });
                  mE._dctr[mId]["adviseMkr"] = advMkr;
                  if (advDetailsNext || routeNm === 0) {
                    var dy = advDetailsNext.lat - advDetails.lat,
                      dx = advDetailsNext.lng - advDetails.lng,
                      theta = Math.atan2(dx, dy);
                    if (adviseNm < 1) {
                      var geomR = rdata.routes[routeNm].geometry;
                      dy = geomR[0][1] - geomR[1][1];
                      (dx = geomR[0][0] - geomR[1][0]),
                        (theta = Math.atan2(dx, dy));
                    }
                    var rotation = (theta *= 180 / Math.PI);
                    var mkId = mE.$("#adviseMkr_" + mId);
                    if (mkId)
                      mkId.style.transform =
                        "rotate(" + (180 + rotation) + "deg)";
                  }
                }
              }
            }
          };
          if (mE.$("#" + mainResId)) {
            mE.$("#" + mainResId).onclick = function (e) {
              var id = e.target.id;
              if (id && id.indexOf("avalRt_") != -1) {
                for (var i = 0; i < totalRoute; i++) {
                  var avaiRt = "avalRt_" + mId + "_" + i,
                    Rclss = mE.$("#" + avaiRt).classList;
                  var inst_rt = mE.$("#" + avaiRt + "_instruct");
                  if (Rclss.value.indexOf("active") != -1 && id == avaiRt) {
                    mE.dr_actRoute(p, rdata, i);
                    if (inst_rt) inst_rt.classList.toggle("active");
                  } else {
                    if (id == avaiRt) {
                      mE.dr_actRoute(p, rdata, i);
                      if (inst_rt) inst_rt.classList.toggle("active");
                    } else {
                      if (inst_rt) {
                        mE.$("#" + avaiRt).classList.toggle("hide");
                        inst_rt.classList.remove("active");
                      }
                    }
                    if (mE._dctr[mId]["adviseMkr"])
                      mE._dctr[mId]["adviseMkr"].remove();
                  }
                }
                if (p.fitbounds !== false && p.map) {
                  mE.fitRt(p.map, resDiv, p);
                }
              }
              if (id && id.indexOf("advise_") != -1) {
                advise(id);
              }
            };
          }
          if (mE.$("#avaibleRt_" + mId)) {
            mE.$("#avaibleRt_" + mId).onclick = function () {
              mE.$("#RTgle_" + mId).classList.toggle("active");
              mE.$("#MMIRouteList_" + mId).classList.toggle("hide");
            };
          }
          mE._dctr[mId]["RoutGEO"] = btoa(JSON.stringify(RoutGEO));
          var ds = "DrS_" + mId,
            dsv = mE._dctr[mId][ds],
            dsl = "LbS_" + mId,
            dslv = mE._dctr[mId][dsl],
            de = "DrE_" + mId,
            dev = mE._dctr[mId][de],
            del = "LbE_" + mId,
            delv = mE._dctr[mId][del];
          mE._dctr[mId]["Request"] = [{ name: dslv, geoposition: dsv }];
          if (mE._dctr[mId]["viaNo"] >= 1) {
            for (var i = 0; i < mE._dctr[mId]["viaNo"]; i++) {
              var vll = mE._dctr[mId]["LbV_" + mId + "" + (i + 1)],
                vvl = mE._dctr[mId]["DrV_" + mId + "" + (i + 1)];
              mE._dctr[mId]["Request"].push({ name: vll, geoposition: vvl });
            }
          }
          mE._dctr[mId]["Request"].push({ name: delv, geoposition: dev });
          if (p.fitBounds !== false && p.map) {
            mE.fitRt(p.map, resDiv, p);
          }
          if (p && p.callback && RTN_callback && p.rtn) {
            p.rtn.data = RTN_callback;
            p.callback(p.rtn);
          }
        }
      },
      fitRt: function (map, resDiv, p) {
        if (map) {
          var wt = map._container.offsetWidth,
            mId = map._container.id,
            RoutGEO = JSON.parse(atob(mE._dctr[mId]["RoutGEO"]));
          var dvWt = 10;
          if (resDiv)
            dvWt = mE.$("#" + resDiv) ? mE.$("#" + resDiv).offsetWidth : 0;
          if (map.type == "L" && RoutGEO) {
            var op = { paddingTopLeft: [dvWt, 40] };
            if (wt < 400) op = { paddingTopLeft: [10, 100] };
            map.fitBounds(
              mE.rvGeom(RoutGEO),
              p && p.fitboundsOptions ? p.fitboundsOptions : op
            );
          } else if (map.type == "M" && RoutGEO) {
            if (!p.fitboundsOptions)
              p.fitboundsOptions = {
                padding: { top: 10, bottom: 25, left: 100, right: 5 },
              };
            MapmyIndia.fitBounds({
              map: map,
              bounds: RoutGEO,
              options: p && p.fitboundsOptions ? p.fitboundsOptions : "",
            });
          }
        }
      },
      rvGeom: function (gem) {
        var ngem = [];
        for (var i = 0; i < gem.length; i++) {
          ngem.push([gem[i][1], gem[i][0]]);
        }
        return ngem;
      },
      dr_actRoute: function (p, rdata, routeNum) {
        if (rdata) {
          var mId = p.map._container.id,
            profile = mE._dctr[mId]["profile"];
          if (!routeNum) routeNum = 0;
          var featr = rdata.routes[routeNum].ftr,
            geom = rdata.routes[routeNum].geometry,
            outerFtr = {
              type: "Feature",
              geometry: { type: "LineString", coordinates: geom },
              properties: {
                stroke: "#1abbf6",
                dashArray: [10, profile == "walking" ? 8 : 0],
                "stroke-width": 4,
              },
            };
          if (!featr || featr.length < 1) featr = [outerFtr];
          else featr.unshift(outerFtr);
          var jso = { type: "FeatureCollection", features: featr };
          var actRoute = "";
          if (p.map.type == "L") {
            if (mE._dctr[mId]["All_routes"]["act"])
              p.map.removeLayer(mE._dctr[mId]["All_routes"]["act"]);
            actRoute = new L.geoJson(jso, mE.RStyle);
            p.map.addLayer(actRoute);
          } else if (p.map.type == "M") {
            if (mE._dctr[mId]["All_routes"]["act"])
              MapmyIndia.remove({
                map: p.map,
                layer: mE._dctr[mId]["All_routes"]["act"],
              });
            actRoute = MapmyIndia.addGeoJson({
              map: p.map,
              cType: 1,
              data: jso,
              dasharray: [1, profile == "walking" ? 2 : 0],
              overlap: true,
              fitbounds: true,
            });
          }
          var pactrtNum = mE._dctr[mId]["All_routes"]["actrtnum"];
          if (p.routecallback && pactrtNum != routeNum) {
            p.routecallback(geom);
          }
          if (actRoute) {
            mE._dctr[mId]["All_routes"]["act"] = actRoute;
            mE._dctr[mId]["All_routes"]["actrtnum"] = routeNum;
            var rtName = mE.$(".mmirtRw active")[0];
            if (rtName) {
              rtName.classList.remove("active");
            }
            var actId = mE.$("#avalRt_" + mId + "_" + routeNum);
            if (actId) actId.classList.add("active");
            var instId = mE.$(".mmirtInst active")[0];
            if (
              instId &&
              instId.id &&
              instId.id.indexOf("_" + routeNum + "_") == -1
            ) {
              instId.classList.remove("active");
              var hiddenRtDv = mE.$(".mmirtRw  hide")[0];
              if (hiddenRtDv) hiddenRtDv.classList.remove("hide");
            }
          }
        }
      },
      dr_rm: function (p, type, resDiv) {
        if (p && p.map) {
          var mId = p.map._container.id,
            routes = mE._dctr[mId]["All_routes"];
          if (routes && (!type || type.indexOf("routes") != -1)) {
            for (var Rtkey in routes) {
              if (Rtkey == "actrtnum") continue;
              var lr = routes[Rtkey];
              if (p.map.type == "L") {
                lr.remove();
              } else if (p.map.type == "M") {
                MapmyIndia.remove({ map: p.map, layer: lr });
              }
              mE._dctr[mId]["All_routes"] = [];
            }
            if (mE._dctr[mId]["adviseMkr"]) {
              mE._dctr[mId]["adviseMkr"].remove();
              mE._dctr[mId]["adviseMkr"] = "";
            }
          }
          if (
            routes &&
            (!type ||
              type.indexOf("routes") != -1 ||
              type.indexOf("tips") != -1)
          ) {
            var tps = mE._dctr[mId]["tips"];
            if (tps) {
              for (var i = 0; i < tps.length; i++) {
                tps[i].remove();
              }
              mE._dctr[mId]["tips"] = [];
            }
          }
          if (!type || type.indexOf("markers") != -1) {
            var mkrs = mE._dctr[mId]["markers"];
            for (mkr in mkrs) {
              mkrs[mkr].remove();
            }
          }
        }
        if (mE.$("#" + resDiv)) mE.$("#" + resDiv).display("none");
      },
      rdist: function (val, type) {
        var rt = val + " mts";
        val = val / 1000;
        if (val >= 1 && val < 10) rt = val.toFixed(2) + " km";
        else if (val >= 10 && val < 100) rt = val.toFixed(1) + " km";
        else if (val >= 100) rt = val.toFixed(0) + " km";
        return rt;
      },
      rtime: function (sc) {
        var sec_num = parseInt(sc, 10),
          hours = Math.floor(sec_num / 3600),
          minutes = Math.floor((sec_num - hours * 3600) / 60),
          seconds = sec_num - hours * 3600 - minutes * 60;
        if (hours < 10) hours = hours;
        if (minutes < 10) minutes = minutes;
        if (seconds < 10) seconds = seconds;
        var time = hours + " <span>h</span> " + minutes + "<span> min </span>";
        if (hours == 0) time = minutes + " <span>min </span>";
        else {
          if (hours == 1)
            time = hours + "<span> h </span>" + minutes + " <span>min </span>";
          else {
            if (hours > 24) {
              var rem_hrs = hours % 24,
                day = (hours - rem_hrs) / 24;
              time =
                day +
                (day == 1 ? "<span> day </span>" : "<span> days </span>") +
                rem_hrs +
                " <span>h </span>" +
                minutes +
                " <span>min</span> ";
            } else
              time =
                hours + " <span>h </span>" + minutes + " <span>min</span> ";
          }
        }
        return time;
      },
      ctrl: function (m, html, cls, pos) {
        if (m && m.type == "L") {
          var ct = L.control({ position: pos.replace("-", "") });
          ct.onAdd = function () {
            var div = L.DomUtil.create("div", cls);
            L.DomEvent.disableScrollPropagation(div);
            L.DomEvent.disableClickPropagation(div);
            div.innerHTML = html;
            return div;
          };
          ct.addTo(m);
          return ct;
        } else if (m && m.type == "M") {
          return MapmyIndia.addControl({ map: m, html: html, position: pos });
        }
      },
      _s: function (s) {
        if (s) {
          s = btoa(encodeURIComponent(s));
          var r = "";
          for (var i = s.length; i > 0; i--) {
            var nstr = s.substring(0, i);
            r += nstr.substr(-1, 1);
          }
          return r;
        }
        return s;
      },
      $: function (dv) {
        var rt =
          dv.indexOf("#") === 0
            ? document.getElementById(dv.substring(1))
            : dv.indexOf(".") === 0
            ? document.getElementsByClassName(dv.substring(1))
            : "";
        if (rt) {
          rt.display = function (t) {
            var v = this;
            if (v.length == undefined) v = [v];
            for (var i = 0; i < v.length; i++) {
              if (t) {
                v[i].style.display = t;
              }
            }
            return rt;
          };
          rt.h = function (h) {
            var v = this;
            if (v.length == undefined) v = [v];
            for (var i = 0; i < v.length; i++) {
              if (h) {
                v[i].innerHTML = h;
                return rt;
              }
            }
          };
        }
        return rt;
      },
      k: "MDY5NGE0MzktMDhmZi00YWQ1LThmZTYtZWI5MGU4NGY1Yzhh",
      au: "d88b633abm237e19c148764d7533a364415e7",
      pth: "https://apis.mapmyindia.com",
      exp: "{exp}",
      [method[0]]: function (p) {
        return mE.gE(p);
      },
      [method[1]]: function (t, p, callback) {
        return mE.sE(t, p, callback);
      },
      [method[2]]: function (p) {
        return mE.eM(p);
      },
      [method[3]]: function (p, callback) {
        return mE.pp(p, callback);
      },
      [method[4]]: function (p, c) {
        return mE.ds4(p, c);
      },
      [method[5]]: function (p, o) {
        return mE.fteM(p, o);
      },
      [method[6]]: function (p) {
        return mE.nr(p);
      },
      [method[7]]: function (p, c) {
        return mE._d(p, c);
      },
      [method[8]]: function (t) {
        return mE.sT(t);
      },
      [method[9]]: function (t) {
        return mE.cT(t);
      },
      mthd: btoa(method),
    });
  if (typeof MapmyIndia == "object") {
    MapmyIndia[method[0]] = function (p) {
      return mE.gE(p);
    };
    MapmyIndia[method[1]] = function (t, p, callback) {
      return mE.sE(t, p, callback);
    };
    MapmyIndia[method[2]] = function (p) {
      return mE.eM(p);
    };
    MapmyIndia[method[3]] = function (p, callback) {
      return mE.pp(p, callback);
    };
    MapmyIndia[method[4]] = function (p, c) {
      return mE.ds4(p, c);
    };
    MapmyIndia[method[5]] = function (p, o) {
      return mE.fteM(p, o);
    };
    MapmyIndia[method[6]] = function (p) {
      return mE.nr(p);
    };
    (MapmyIndia[method[7]] = function (p, c) {
      return mE._d(p, c);
    }),
      (MapmyIndia[method[8]] = function (t) {
        return mE.sT(t);
      }),
      (MapmyIndia[method[9]] = function (t) {
        return mE.cT(t);
      });
  } else {
    w.MapmyIndia = mE;
  }
})(window, [
  atob("Z2V0RWxvYw=="),
  atob("c2VhcmNo"),
  atob("ZWxvY01hcmtlcg=="),
  atob("cGxhY2VQaWNrZXI="),
  atob("Z2V0RGlzdGFuY2U="),
  atob("Zml0TWFya2Vycw=="),
  atob("bmVhcmJ5"),
  atob("ZGlyZWN0aW9u"),
  atob("c2V0VG9rZW4="),
  atob("dG9rZW5fZXhwaXJl"),
]);
