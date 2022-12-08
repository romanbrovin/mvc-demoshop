(function() {
    function l(a) {
        a = {
            Options: a,
            jZipField: null,
            Fields: [],
            FieldsByLevels: {},
            BuildQueryUpTo: function(a) {
                for (var b = "", c = 0, g = 0; g < this.Fields.length; g++)
                    if (e.IsLessOrEqualLevel(this.Fields[g].MinLevel, a.MinLevel)) { var h = this.Fields[g].GetValue(); if (0 < h.length || this.Fields[g] === a) b += e.GetLevelsSigns(this.Fields[g].Levels), b += "[", b += e.EscapeQuery(h), b += "]", c += h.length } else this.Fields[g].ClearValue();
                this.jZipField && (a = this.jZipField.val(), b += f.ZipLevel.sign, b = b + "[" + e.EscapeQuery(a), b += "]", c += a.length);
                return 0 < c ? b : ""
            },
            IsTailField: function(a) { return null == e.Find(this.Fields, function(b) { return e.IsLessLevel(a.MaxLevel, b.MinLevel) && "" != b.GetValue() }) },
            RefreshForm: function(a, b) { this.ClearAllFields(); for (var c = null, g = 0; g < b.length; g++) c = this.FieldsByLevels[b[g].level], c.AppendValue(b[g].type + " " + b[g].name);
                c && c != a && c.SetFocus(!0) },
            ClearAllFields: function() { for (var a = 0; a < this.Fields.length; a++) this.Fields[a].ClearValue() },
            Init: function() {
                for (var a = this, b = 0; b < this.Options.fields.length; b++) this.Fields.push(n(this,
                    this.Options.fields[b]));
                for (b = 0; b < this.Fields.length; b++)
                    for (Level in f.AddressLevels) e.IsLessOrEqualLevel(this.Fields[b].MinLevel, Level) && e.IsLessOrEqualLevel(Level, this.Fields[b].MaxLevel) && (this.FieldsByLevels[Level] = this.Fields[b]);
                void 0 !== this.Options.zip_field && (b = this.Options.zip_field.id, this.jZipField = "string" == typeof b && "#" !== b[0] && "." !== b[0] ? $("#" + b) : $(b), this.jZipField.on("keyup" + f.EventsNamespace, function() { a.ClearAllFields() }), this.jZipField.on("input" + f.EventsNamespace, function() { a.ClearAllFields() }),
                    this.jZipField.on("change" + f.EventsNamespace, function() { a.ClearAllFields() }))
            },
            Dispose: function() { for (var a = 0; a < this.Fields.length; a++) this.Fields[a].Dispose() }
        };
        a.Init();
        return a
    }

    function n(a, d) {
        var b = {
            Options: e.BuildFieldOptions(d, a.Options, "site/suggest/address"),
            AddressForm: a,
            Levels: d.levels,
            MinLevel: "",
            MaxLevel: "",
            EXT: {
                PrepareQuery: function(a) {
                    a = "discrete";
                    this.Options.obsolete_names && (a += "|obsnames");
                    this.Options.obsolete_objects && (a += "|obsobjects");
                    return {
                        query: this.AddressForm.BuildQueryUpTo(this),
                        mode: a,
                        addresslim: this.Options.limit
                    }
                },
                IsAllowedToSuggestOnFocus: function() { return this.AddressForm.IsTailField(this) && this.Options.suggest_on_focus },
                IsAllowedQuery: function(a, b) { var c = a.query && 0 < a.query.length ? !0 : !1;
                    c && 0 == b.length && (c = this.Options.suggest_on_empty); return c },
                OnChooseSuggestion: function(a) {
                    var b = [],
                        b = a.a_machine ? e.DecodeMachineAddress(a.a_machine) : a.f_machine ? e.DecodeMachineAddress(a.f_machine) : e.DecodeMachineAddress(a.machine);
                    this.AddressForm.RefreshForm(this, b);
                    this.Options.on_choose &&
                        this.Options.on_choose.call(this.Options.on_choose_context, a);
                    this.Options.on_fetch && (b = $.extend({ query: a.sign }, this.AddressForm.Options.api_options), b.output = b.output ? b.output + "|json" : "json", this.Options.user && (b.user = this.Options.user), $.ajax({ type: "GET", url: this.Options.ahunter_url + "site/fetch/address", data: b, cache: !1, context: this, success: function(b) { this.Options.on_fetch.call(this.Options.on_fetch_context, a, b.address) } }))
                },
                SuggestionViewInList: function(a) { return e.AddressSuggestionViewInList(a) },
                SuggestionViewInField: function(a) { return a.value }
            },
            ClearValue: function() { this.ResetField("");
                this.ClearSuggestions() },
            AppendValue: function(a) { var b = this.GetValue();
                b && (b += ", ");
                this.ResetField(b + a) },
            Init: function() {
                this.MinLevel = f.AddressLevels.Flat.name;
                this.MaxLevel = f.AddressLevels.Region.name;
                for (var a = 0; a < this.Levels.length; a++) e.IsLessLevel(this.Levels[a], this.MinLevel) && (this.MinLevel = this.Levels[a]), e.IsLessLevel(this.MaxLevel, this.Levels[a]) && (this.MaxLevel = this.Levels[a]);
                void 0 === d.empty_msg &&
                    this.MinLevel === f.AddressLevels.Flat.name && (this.Options.empty_msg = "")
            }
        };
        b.Init();
        var c = k(b.Options.id, b.Options.max_height, b.Options.z_index, b.Options.full_url, b.Options.empty_msg, b.Options.append_to, b.Options.on_edit, b.Options.on_edit_context);
        return e.ExtendSuggester(c, b)
    }

    function p(a) {
        a = {
            Options: e.BuildFieldOptions(a, {}, "site/suggest/address"),
            EXT: {
                PrepareQuery: function(a) {
                    a = { query: a, addresslim: this.Options.limit };
                    var c = "";
                    this.Options.obsolete_names && (c += "obsnames|");
                    this.Options.obsolete_objects &&
                        (c += "obsobjects|");
                    0 < c.length && (a.mode = c);
                    return a
                },
                IsAllowedToSuggestOnFocus: function() { return this.Options.suggest_on_focus },
                OnChooseSuggestion: function(a) {
                    this.Options.on_choose && this.Options.on_choose.call(this.Options.on_choose_context, a);
                    if (this.Options.on_fetch) {
                        var c = $.extend({ query: a.sign }, this.Options.api_options);
                        c.output = c.output ? c.output + "|json" : "json";
                        this.Options.user && (c.user = this.Options.user);
                        $.ajax({
                            type: "GET",
                            url: this.Options.ahunter_url + "site/fetch/address",
                            data: c,
                            cache: !1,
                            context: this,
                            success: function(c) { this.Options.on_fetch.call(this.Options.on_fetch_context, a, c.address) }
                        })
                    }
                },
                SuggestionViewInList: function(a) { return e.AddressSuggestionViewInList(a) },
                SuggestionViewInField: function(a) { var c = null,
                        c = a.a_machine ? e.DecodeMachineAddress(a.a_machine) : a.f_machine ? e.DecodeMachineAddress(a.f_machine) : e.DecodeMachineAddress(a.machine); return e.AddressFieldsToString(c, !0) }
            },
            Init: function() {}
        };
        a.Init();
        var d = k(a.Options.id, a.Options.max_height, a.Options.z_index, a.Options.full_url, a.Options.empty_msg,
            a.Options.append_to, a.Options.on_edit, a.Options.on_edit_context);
        return e.ExtendSuggester(d, a)
    }

    function q(a) {
        a = {
            Options: a,
            Fields: [],
            BuildQueryWithActiveField: function(a) { return { active: a.Tag, last_name: this.GetFieldValue("last_name"), first_name: this.GetFieldValue("first_name"), patronym: this.GetFieldValue("patronym") } },
            GetFieldValue: function(a) { var b = e.Find(this.Fields, function(b) { return b.Tag == a }); return null != b ? b.GetValue() : "" },
            GetPerson: function() {
                for (var a = {
                        last_name: this.GetFieldValue("last_name"),
                        first_name: this.GetFieldValue("first_name"),
                        patronym: this.GetFieldValue("patronym"),
                        full_name: ""
                    }, b = 0; b < this.Fields.length; b++) a.full_name.length && this.Fields[b].GetValue().length && (a.full_name += " "), a.full_name += this.Fields[b].GetValue();
                return a
            },
            Init: function() { for (var a = 0; a < this.Options.fields.length; a++) this.Fields.push(r(this, this.Options.fields[a])) },
            Dispose: function() { for (var a = 0; a < this.Fields.length; a++) this.Fields[a].Dispose() }
        };
        a.Init();
        return a
    }

    function r(a, d) {
        var b = {
            Options: e.BuildFieldOptions(d,
                a.Options, "site/suggest/person"),
            PersonForm: a,
            Tag: d.tag,
            EXT: {
                PrepareQuery: function(a) { return $.extend(this.PersonForm.BuildQueryWithActiveField(this), { personlim: this.Options.limit }) },
                IsAllowedToSuggestOnFocus: function() { return this.Options.suggest_on_focus },
                IsAllowedQuery: function(a, b) { return 0 < b.length },
                OnChooseSuggestion: function(a) {
                    this.Options.on_choose && this.Options.on_choose.call(this.Options.on_choose_context, a);
                    this.Options.on_fetch && this.Options.on_fetch.call(this.Options.on_fetch_context,
                        a, this.PersonForm.GetPerson())
                }
            },
            Init: function() {}
        };
        b.Init();
        var c = k(b.Options.id, b.Options.max_height, b.Options.z_index, b.Options.full_url, b.Options.empty_msg, b.Options.append_to, b.Options.on_edit, b.Options.on_edit_context);
        return e.ExtendSuggester(c, b)
    }

    function t(a) {
        a = {
            Options: e.BuildFieldOptions(a, {}, "site/suggest/person"),
            EXT: {
                PrepareQuery: function(a) { return { query: a, personlim: this.Options.limit } },
                IsAllowedToSuggestOnFocus: function() { return this.Options.suggest_on_focus },
                OnChooseSuggestion: function(a) {
                    this.Options.on_choose &&
                        this.Options.on_choose.call(this.Options.on_choose_context, a);
                    this.Options.on_fetch && this.Options.on_fetch.call(this.Options.on_fetch_context, a, { full_name: a.value })
                }
            },
            Init: function() {}
        };
        a.Init();
        var d = k(a.Options.id, a.Options.max_height, a.Options.z_index, a.Options.full_url, a.Options.empty_msg, a.Options.append_to, a.Options.on_edit, a.Options.on_edit_context);
        return SolidSuggester = e.ExtendSuggester(d, a)
    }

    function u(a) {
        a = {
            Options: e.BuildFieldOptions(a, {}, "site/suggest/company"),
            EXT: {
                PrepareQuery: function(a) {
                    a = { query: a, mode: "", companylim: this.Options.limit, afilter: JSON.stringify(this.Options.filter) };
                    if (this.Options.egrul_enable || !this.Options.egrip_enable) a.mode = "egrul";
                    this.Options.egrip_enable && (a.mode += "|egrip");
                    return a
                },
                IsAllowedToSuggestOnFocus: function() { return this.Options.suggest_on_focus },
                OnChooseSuggestion: function(a) {
                    this.Options.on_choose && this.Options.on_choose.call(this.Options.on_choose_context, a);
                    if (this.Options.on_fetch) {
                        var c = $.extend({ query: a.sign }, this.Options.api_options);
                        c.output =
                            c.output ? c.output + "|json" : "json";
                        this.Options.user && (c.user = this.Options.user);
                        $.ajax({ type: "GET", url: this.Options.ahunter_url + "site/fetch/company", data: c, cache: !1, context: this, success: function(c) { this.Options.on_fetch.call(this.Options.on_fetch_context, a, c.company) } })
                    }
                },
                SuggestionViewInList: function(a) { return e.CompanySuggestionViewInList(a) },
                SuggestionViewInField: function(a) { return a.name }
            },
            Init: function() {}
        };
        a.Init();
        var d = k(a.Options.id, a.Options.max_height, a.Options.z_index, a.Options.full_url,
            a.Options.empty_msg, a.Options.append_to, a.Options.on_edit, a.Options.on_edit_context);
        return SolidSuggester = e.ExtendSuggester(d, a)
    }

    function v(a) {
        a = {
            Options: e.BuildFieldOptions(a, {}, "site/suggest/company"),
            jAddressField: null,
            jPersonField: null,
            EXT: {
                PrepareQuery: function(a) {
                    var c = "",
                        d = f.CompanyFields.Name.sign;
                    this.jAddressField ? c += f.CompanyFields.Address.sign + "[" + this.jAddressField.val() + "]" : d += f.CompanyFields.Address.sign;
                    this.jPersonField ? c += f.CompanyFields.Person.sign + "[" + this.jPersonField.val() +
                        "]" : d += f.CompanyFields.Person.sign;
                    var e = "discrete";
                    this.Options.egrul_enable && (e += "|egrul");
                    this.Options.egrip_enable && (e += "|egrip");
                    return { query: c + (d + "[" + a + "]"), mode: e, companylim: this.Options.limit, afilter: JSON.stringify(this.Options.filter) }
                },
                ProcessedQueryForHighlight: function(a) { var c = "";
                    this.jAddressField && (c += this.jAddressField.val() + " ");
                    this.jPersonField && (c += this.jPersonField.val() + " "); return c + a },
                IsAllowedToSuggestOnFocus: function() { return this.Options.suggest_on_focus },
                OnChooseSuggestion: function(a) {
                    this.Options.on_choose &&
                        this.Options.on_choose.call(this.Options.on_choose_context, a);
                    if (this.Options.on_fetch) { var c = $.extend({ query: a.sign }, this.Options.api_options);
                        c.output = c.output ? c.output + "|json" : "json";
                        this.Options.user && (c.user = this.Options.user);
                        $.ajax({ type: "GET", url: this.Options.ahunter_url + "site/fetch/company", data: c, cache: !1, context: this, success: function(c) { this.Options.on_fetch.call(this.Options.on_fetch_context, a, c.company) } }) }
                },
                SuggestionViewInList: function(a) { return e.CompanySuggestionViewInList(a) },
                SuggestionViewInField: function(a) { return a.name }
            },
            Init: function() { void 0 !== this.Options.company_address_id && (this.jAddressField = e.GetField(this.Options.company_address_id));
                void 0 !== this.Options.company_person_id && (this.jPersonField = e.GetField(this.Options.company_person_id)) }
        };
        a.Init();
        var d = k(a.Options.id, a.Options.max_height, a.Options.z_index, a.Options.full_url, a.Options.empty_msg, a.Options.append_to, a.Options.on_edit, a.Options.on_edit_context);
        return DiscreteSuggester = e.ExtendSuggester(d, a)
    }

    function k(a, d, b, c, g, h, k, l) {
        a = {
            EXT: {
                PrepareQuery: function(a) { return { query: a } },
                ProcessedQueryForHighlight: function(a) { return a },
                IsAllowedToSuggestOnFocus: function() { return !0 },
                IsAllowedQuery: function(a, b) { return a.query && 0 < a.query.length && 0 < b.length },
                OnEditField: function(a, b) { k && k.call(l, a, b) },
                OnChooseSuggestion: function(a) {},
                SuggestionViewInList: function(a) { return a.value },
                SuggestionViewInField: function(a) { return a.value }
            },
            jField: e.GetField(a),
            SuggestionsClass: "u-AhunterSuggestions",
            SuggestionClass: "u-AhunterSuggestion",
            SuggestionSpecialClass: "u-AhunterSpecialSuggestion",
            SuggestionMainValueClass: "u-AhunterSuggestionMainValue",
            SuggestionSubValueClass: "u-AhunterSuggestionSubValue",
            SelectedSuggestionClass: "u-AhunterSelectedSuggestion",
            EmptySuggestionClass: "u-AhunterEmptySuggestion",
            jSuggestions: $("<div></div>"),
            jAppendTo: "string" == typeof h && "#" !== h[0] && "." !== h[0] ? $("#" + h) : $(h),
            Suggestions: [],
            SelectedIndex: -1,
            UserValue: "",
            ShownValue: "",
            IsHidden: !0,
            GetValue: function() { return this.jField.val() },
            SplitText: function(a, b) {
                for (var c = /[\s\\\/,;.\-"'<>\[\]()*]/gi, d = 0; d < a.length;) {
                    var e = c.exec(a),
                        e = null !== e ? e.index : a.length;
                    d < e && b(d,
                        e);
                    d = e + 1
                }
            },
            FormatSuggestionValue: function(a) {
                var b = this.EXT.ProcessedQueryForHighlight.call(this, this.UserValue),
                    c = [];
                this.SplitText(b, function(a, d) { c.push({ word: b.substring(a, d).toLowerCase(), prefix: d == b.length }) });
                var d = "",
                    f = 0;
                this.SplitText(a, function(b, g) {
                    d += a.substring(f, b);
                    var m = a.substring(b, g).toLowerCase(),
                        h = e.Find(c, function(a, b) { return a.word == m || a.prefix && a.word == m.substring(0, a.word.length) });
                    h ? (d += "<strong>" + a.substring(b, b + h.word.length) + "</strong>", d += a.substring(b + h.word.length, g)) :
                        d += a.substring(b, g);
                    f = g
                });
                d += a.substring(f);
                d.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/&lt;(\/?strong)&gt;/g, "<$1>");
                return d
            },
            ShowSuggestions: function() {
                var a = !0;
                this.UpdatePosition();
                this.jSuggestions.empty();
                this.Suggestions || (this.Suggestions = []);
                if (0 < this.Suggestions.length)
                    for (var b = 0; b < this.Suggestions.length; b++) {
                        var c = this.EXT.SuggestionViewInList(this.Suggestions[b]);
                        "string" == typeof c && (c = { Lines: [c], Special: !1 });
                        var d = $("<div>");
                        $("<div>" +
                            this.FormatSuggestionValue(c.Lines[0]) + "</div>").appendTo(d).addClass(this.SuggestionMainValueClass);
                        for (var e = 1; e < c.Lines.length; e++) $("<div>" + this.FormatSuggestionValue(c.Lines[e]) + "</div>").appendTo(d).addClass(this.SuggestionSubValueClass);
                        d.addClass(this.SuggestionClass);
                        c.Special && d.addClass(this.SuggestionSpecialClass);
                        d.appendTo(this.jSuggestions)
                    } else g ? $("<div>" + g + "</div>").appendTo(this.jSuggestions).addClass(this.EmptySuggestionClass) : a = !1;
                a ? (this.jSuggestions.show(), this.IsHidden = !1,
                    this.HighliteSuggestion(this.SelectedIndex)) : this.ClearSuggestions()
            },
            HideSuggestions: function() { this.jSuggestions.hide();
                this.IsHidden = !0 },
            ClearSuggestions: function() { this.Suggestions = [];
                this.SelectedIndex = -1;
                this.jSuggestions.empty();
                this.HideSuggestions() },
            UpdatePosition: function() {
                var a = this.jField.position(),
                    b = this.jField.offsetParent().offset(),
                    c = this.jAppendTo.offset(),
                    d = a.left + (b.left - c.left),
                    a = a.top + (b.top - c.top);
                this.jSuggestions.detach();
                this.jSuggestions.appendTo(this.jAppendTo);
                this.jSuggestions.css("position",
                    "absolute");
                this.jSuggestions.css("left", d);
                this.jSuggestions.css("top", a + this.jField.outerHeight());
                this.jSuggestions.css("width", this.jField.outerWidth())
            },
            NavigateSuggestions: function(a) {
                var b = !1;
                a.which == f.Keys.ESC ? (b = !0, this.ResetField(this.UserValue), this.HideSuggestions()) : a.which == f.Keys.DOWN && 0 < this.Suggestions.length ? (b = !0, this.IsHidden ? (this.ShowSuggestions(), this.SelectSuggestion(this.SelectedIndex)) : this.SelectSuggestion(this.SelectedIndex + 1)) : a.which == f.Keys.UP && 0 < this.Suggestions.length ?
                    (b = !0, this.IsHidden ? (this.ShowSuggestions(), this.SelectSuggestion(this.SelectedIndex)) : this.SelectSuggestion(this.SelectedIndex - 1)) : a.which == f.Keys.ENTER && !this.IsHidden && 0 <= this.SelectedIndex ? (b = !0, this.SelectSuggestion(this.SelectedIndex), this.ResetField(this.ShownValue), this.EXT.OnChooseSuggestion.call(this, this.Suggestions[this.SelectedIndex]), this.ClearSuggestions()) : a.which != f.Keys.TAB || this.IsHidden || (0 <= this.SelectedIndex ? (this.SelectSuggestion(this.SelectedIndex), this.ResetField(this.ShownValue),
                        this.EXT.OnChooseSuggestion.call(this, this.Suggestions[this.SelectedIndex])) : this.ResetField(this.UserValue), this.ClearSuggestions());
                return !b
            },
            SelectSuggestion: function(a) { this.SelectedIndex = -1 > a ? this.Suggestions.length - 1 : a >= this.Suggestions.length ? -1 : a; - 1 != this.SelectedIndex ? (this.ShownValue = this.EXT.SuggestionViewInField(this.Suggestions[this.SelectedIndex]), this.jField.val(this.ShownValue)) : this.ResetField(this.UserValue);
                this.HighliteSuggestion(this.SelectedIndex) },
            ResetField: function(a) {
                this.ShownValue =
                    this.UserValue = a;
                this.jField.val(a)
            },
            HighliteSuggestion: function(a) { this.jSuggestions.children().removeClass(this.SelectedSuggestionClass); - 1 != a && a < this.Suggestions.length && (a = this.jSuggestions.children().get(a), $(a).addClass(this.SelectedSuggestionClass)) },
            UpdateSuggestions: function(a) {
                var b = this.jField.val(),
                    d = !1;
                this.ShownValue != b && (d = !0, this.EXT.OnEditField(this.ShownValue, b));
                if (d || a) {
                    var e = this;
                    e.ResetField(b);
                    e.SelectedIndex = -1;
                    a = this.EXT.PrepareQuery.call(this, b);
                    this.EXT.IsAllowedQuery.call(this,
                        a, b) ? (b = $.extend({ output: "json", ahungest: f.Version }, a), $.ajax({ type: "GET", url: c, data: b, cache: !1, context: this, success: function(a) { e.Suggestions = a.suggestions;
                            e.ShowSuggestions() } })) : e.ClearSuggestions()
                }
            },
            SetFocus: function(a) { var b = this.EXT.IsAllowedToSuggestOnFocus;
                a && (this.EXT.IsAllowedToSuggestOnFocus = function() { return !1 });
                this.jField.focus();
                a && (this.EXT.IsAllowedToSuggestOnFocus = b) },
            Init: function() {
                var a = this;
                this.ResetField(this.jField.val());
                this.jSuggestions.addClass(this.SuggestionsClass);
                this.jSuggestions.css("max-height", d);
                this.jSuggestions.css("z-index", b);
                this.jSuggestions.hide();
                this.UpdatePosition();
                this.jField.attr("autocomplete", "off");
                this.jSuggestions.on("mouseover" + f.EventsNamespace, "." + this.SuggestionClass, function() { a.SelectedIndex = $(this).index();
                    a.HighliteSuggestion(a.SelectedIndex) });
                this.jSuggestions.on("mouseout" + f.EventsNamespace, function() { a.SelectedIndex = -1;
                    a.HighliteSuggestion(a.SelectedIndex) });
                this.jSuggestions.on("mousedown" + f.EventsNamespace, "." + this.SuggestionClass,
                    function(b) { if (1 == b.which) return a.SelectedIndex = $(this).index(), a.SelectSuggestion(a.SelectedIndex), a.ResetField(a.ShownValue), a.EXT.OnChooseSuggestion.call(a, a.Suggestions[a.SelectedIndex]), a.ClearSuggestions(), a.SetFocus(!0), !1 });
                this.jField.on("keydown" + f.EventsNamespace, function(b) { return a.NavigateSuggestions(b) });
                this.jField.on("keyup" + f.EventsNamespace, function() { a.UpdateSuggestions() });
                this.jField.on("input" + f.EventsNamespace, function() { a.UpdateSuggestions() });
                this.jField.on("change" + f.EventsNamespace,
                    function() { a.UpdateSuggestions() });
                this.jField.on("blur" + f.EventsNamespace, function() { a.IsHidden || (a.ResetField(a.UserValue), a.ClearSuggestions()) });
                this.jField.on("focus" + f.EventsNamespace, function() { a.EXT.IsAllowedToSuggestOnFocus.call(a) && a.UpdateSuggestions(!0) });
                $(window).on("resize" + f.EventsNamespace, function() { a.UpdatePosition() })
            },
            Dispose: function() { this.jSuggestions.off(f.EventsNamespace);
                this.jField.off(f.EventsNamespace);
                $(window).off(f.EventsNamespace);
                this.jSuggestions.remove() }
        };
        a.Init();
        return a
    }
    window.AhunterSuggest = {
        Address: { Discrete: function(a) { var d = { obj: null, deffered: !1 };
                $(document).ready(function() { d.obj = l(a) });
                this.Running.push(d); return d }, Solid: function(a) { var d = { obj: null, deffered: !1 };
                $(document).ready(function() { d.obj = p(a) });
                this.Running.push(d); return d }, Running: [] },
        Person: {
            Discrete: function(a) { var d = { obj: null, deffered: !1 };
                $(document).ready(function() { d.obj = q(a) });
                this.Running.push(d); return d },
            Solid: function(a) {
                var d = { obj: null, deffered: !1 };
                $(document).ready(function() {
                    d.obj =
                        t(a)
                });
                this.Running.push(d);
                return d
            },
            Running: []
        },
        Company: { Discrete: function(a) { var d = { obj: null, deffered: !1 };
                $(document).ready(function() { d.obj = v(a) });
                this.Running.push(d); return d }, Solid: function(a) { var d = { obj: null, deffered: !1 };
                $(document).ready(function() { d.obj = u(a) });
                this.Running.push(d); return d }, Running: [] },
        Dispose: function(a) {
            this.FindAndDispose(a, this.Address.Running);
            this.FindAndDispose(a, this.Person.Running);
            this.FindAndDispose(a, this.Company.Running);
            this.DisposeDeffered(this.Address.Running);
            this.DisposeDeffered(this.Person.Running);
            this.DisposeDeffered(this.Company.Running)
        },
        FindAndDispose: function(a, d) { var b = e.FindIndex(d, function(b) { return a == b }); - 1 != b && (d[b].obj ? (d[b].obj.Dispose(), d.splice(b, 1)) : d[b].deffered = !0) },
        DisposeDeffered: function(a) { for (var d = a.length - 1; 0 <= d; d--) a[d].deffered && a[d].obj && (a[d].obj.Dispose(), a.splice(d, 1)) }
    };
    var f = {
            Version: "3.1",
            EventsNamespace: ".ahungest",
            AddressLevels: {
                Region: { name: "Region", sign: "r", num: 0 },
                District: { name: "District", sign: "d", num: 1 },
                City: {
                    name: "City",
                    sign: "c",
                    num: 2
                },
                Place: { name: "Place", sign: "p", num: 3 },
                Site: { name: "Site", sign: "t", num: 4 },
                Street: { name: "Street", sign: "s", num: 5 },
                House: { name: "House", sign: "h", num: 6 },
                Building: { name: "Building", sign: "b", num: 7 },
                Structure: { name: "Structure", sign: "u", num: 8 },
                Flat: { name: "Flat", sign: "f", num: 9 }
            },
            ZipLevel: { name: "Zip", sign: "z" },
            CompanyFields: { Name: { name: "Name", sign: "n", num: 0 }, Address: { name: "Address", sign: "a", num: 1 }, Person: { name: "Person", sign: "p", num: 2 } },
            Keys: { ESC: 27, TAB: 9, ENTER: 13, UP: 38, DOWN: 40 },
            DefaultOptions: {
                ahunter_url: "https://ahunter.ru/",
                empty_msg: "Нет подходящей подсказки",
                limit: 10,
                suggest_on_empty: !1,
                suggest_on_focus: !0,
                obsolete_names: !1,
                obsolete_objects: !1,
                z_index: 9999,
                max_height: 500,
                append_to: null,
                id: void 0,
                on_edit: void 0,
                on_edit_context: void 0,
                on_choose: void 0,
                on_choose_context: void 0,
                on_fetch: void 0,
                on_fetch_context: void 0,
                user: void 0,
                api_options: void 0,
                filter: void 0,
                company_address_id: void 0,
                company_person_id: void 0,
                egrul_enable: !0,
                egrip_enable: !0
            }
        },
        e = {
            GetField: function(a) {
                return "string" == typeof a && "#" !== a[0] && "." !== a[0] ? $("#" +
                    a) : $(a)
            },
            FindIndex: function(a, d) { for (var b = -1, c = 0; c < a.length; c++)
                    if (d(a[c])) { b = c; break } return b },
            Find: function(a, d) { var b = null,
                    c = this.FindIndex(a, d); - 1 != c && (b = a[c]); return b },
            IsLessLevel: function(a, d) { return f.AddressLevels[a].num < f.AddressLevels[d].num },
            IsLessOrEqualLevel: function(a, d) { return f.AddressLevels[a].num <= f.AddressLevels[d].num },
            IsNumericLevel: function(a) { return f.AddressLevels[a].num >= f.AddressLevels.House.num },
            IsAddressLevel: function(a) { return a in f.AddressLevels },
            FindAddressLevelBySign: function(a) {
                var d =
                    "";
                for (Level in f.AddressLevels)
                    if (f.AddressLevels[Level].sign == a) { d = f.AddressLevels[Level].name; break } return d
            },
            GetLevelsSigns: function(a) { for (var d = "", b = 0; b < a.length; b++) d += f.AddressLevels[a[b]].sign; return d },
            EscapeQuery: function(a) { return a.replace(/([\\\[\]])/g, "\\$1") },
            DecodeMachineAddress: function(a) {
                for (var d = [], b = 0, c = "", g = { name: "", type: "", level: f.AddressLevels.Region.name }; b < a.length;) {
                    if ("\\" != a[b] && ":" != a[b]) {
                        var h = e.FindAddressLevelBySign(a[b]);
                        "" === h ? c += a[b] : (g.name = c, d.push(g), c = "",
                            g = { name: "", type: "", level: h }, g.level = h)
                    } else "\\" == a[b] ? (b++, b < a.length && (c += a[b])) : ":" == a[b] && (g.type = c, c = "");
                    b++
                }
                0 < c.length && (g.name = c, d.push(g));
                return d
            },
            AddressFieldsDelta: function(a, d) { for (var b = [], c = 0, f = 0; c < a.length && f < d.length;)
                    if (e.IsLessLevel(a[c].level, d[f].level)) b.push(a[c]), c++;
                    else if (e.IsLessLevel(d[f].level, a[c].level)) { 0 < c && c--; break } else a[c].type == d[f].type && a[c].name == d[f].name || b.push(a[c]), c++, f++; for (; c < a.length;) b.push(a[c]), c++; return b },
            AddressFieldsToString: function(a, d) {
                for (var b = !1, c = "", f = 0; f < a.length; f++) c.length && (c += ", "), c += a[f].type + " " + a[f].name, e.IsNumericLevel(a[f].level) && (b = !0);
                d && !b && (c += ", ");
                return c
            },
            AddressSuggestionViewInList: function(a) {
                var d = a.value;
                if (a.f_machine || a.a_machine) {
                    var b = e.DecodeMachineAddress(a.machine),
                        c = null,
                        f = "";
                    a.f_machine && (c = e.DecodeMachineAddress(a.f_machine), f = e.AddressFieldsDelta(c, b), f = e.AddressFieldsToString(f));
                    var h = "";
                    a.a_machine && (a = e.DecodeMachineAddress(a.a_machine), b = e.AddressFieldsDelta(a, c ? c : b), h = e.AddressFieldsToString(b));
                    if (f || h) d += " (", f && (d += " → " + f), h && (d += " ⇒ " + h), d += " )"
                }
                return d
            },
            CompanySuggestionViewInList: function(a) { return { Lines: [a.name, a.address, a.ogrn + ", ИНН: " + a.inn + (0 < a.person.length ? ", " + a.person : "")], Special: 0 == a.state ? !1 : !0 } },
            ExtendSuggester: function(a, d) { var b = a.EXT;
                $.extend(a, d);
                a.EXT = $.extend(b, d.EXT); return a },
            SelectDefined: function() { for (var a, d = 0; d < arguments.length; d++)
                    if (void 0 !== arguments[d]) { a = arguments[d]; break } return a },
            BuildFieldOptions: function(a, d, b) {
                var c = {};
                for (Name in f.DefaultOptions) c[Name] =
                    e.SelectDefined(a[Name], d[Name], f.DefaultOptions[Name]);
                "/" != c.ahunter_url[c.ahunter_url.length - 1] && (c.ahunter_url += "/");
                c.append_to || (c.append_to = $(document.body));
                c.full_url = c.ahunter_url + b;
                return c
            }
        }
})();
