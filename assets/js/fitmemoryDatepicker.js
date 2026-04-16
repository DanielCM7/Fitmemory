(function () {
  function resolveDatepickerTarget(target) {
    if (typeof target === "string") {
      return document.querySelector(target);
    }
    return target instanceof HTMLElement ? target : null;
  }

  function getAirDatepickerCtor() {
    if (typeof window.AirDatepicker === "undefined") {
      return null;
    }

    if (typeof window.AirDatepicker === "function") {
      return window.AirDatepicker;
    }

    if (
      window.AirDatepicker &&
      typeof window.AirDatepicker.default === "function"
    ) {
      return window.AirDatepicker.default;
    }

    return null;
  }

  function getSpanishLocale() {
    return {
      days: [
        "Domingo",
        "Lunes",
        "Martes",
        "Miercoles",
        "Jueves",
        "Viernes",
        "Sabado",
      ],
      daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
      daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
      months: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ],
      monthsShort: [
        "Ene",
        "Feb",
        "Mar",
        "Abr",
        "May",
        "Jun",
        "Jul",
        "Ago",
        "Sep",
        "Oct",
        "Nov",
        "Dic",
      ],
      today: "Hoy",
      clear: "Limpiar",
      dateFormat: "dd/MM/yyyy",
      timeFormat: "hh:mm aa",
      firstDay: 1,
    };
  }

  function parseYear(value) {
    if (value instanceof Date) return value.getFullYear();
    if (typeof value === "number") return value;
    if (typeof value === "string" && value.length >= 4) {
      var parsed = Number.parseInt(value.slice(0, 4), 10);
      return Number.isNaN(parsed) ? null : parsed;
    }
    return null;
  }

  function parseDate(value) {
    if (!value) return null;
    if (value instanceof Date) return value;
    if (value === "today") return new Date();

    if (typeof value === "string") {
      var d = new Date(value);
      return Number.isNaN(d.getTime()) ? null : d;
    }

    return null;
  }

  function formatYmd(date) {
    if (!(date instanceof Date) || Number.isNaN(date.getTime())) return "";
    var y = date.getFullYear();
    var m = String(date.getMonth() + 1).padStart(2, "0");
    var d = String(date.getDate()).padStart(2, "0");
    return y + "-" + m + "-" + d;
  }

  function normalizeBounds(options) {
    var bounds = (options && options.yearBounds) || {};
    var minYear = parseYear(bounds.minDate || bounds.min);
    var maxYear = parseYear(bounds.maxDate || bounds.max);

    var minDate = parseDate(options && options.minDate);
    var maxDate = parseDate(options && options.maxDate);

    if (!minDate && minYear !== null) {
      minDate = new Date(minYear, 0, 1);
    }
    if (!maxDate && maxYear !== null) {
      maxDate = new Date(maxYear, 11, 31);
    }

    if (minDate && maxDate && minDate > maxDate) {
      var tmp = minDate;
      minDate = maxDate;
      maxDate = tmp;
    }

    return { minDate: minDate, maxDate: maxDate };
  }

  function coerceSelectedDates(dateValue) {
    if (Array.isArray(dateValue)) {
      return dateValue.filter(function (d) {
        return d instanceof Date && !Number.isNaN(d.getTime());
      });
    }

    if (dateValue instanceof Date && !Number.isNaN(dateValue.getTime())) {
      return [dateValue];
    }

    return [];
  }

  window.initFitmemoryDatepicker = function (target, options) {
    var element = resolveDatepickerTarget(target);
    var AirDatepickerCtor = getAirDatepickerCtor();

    if (!element || !AirDatepickerCtor) {
      return null;
    }

    var customOptions = Object.assign({}, options || {});
    var userOnReady = customOptions.onReady;
    var userOnOpen = customOptions.onOpen;
    var userOnMonthChange = customOptions.onMonthChange;
    var userOnYearChange = customOptions.onYearChange;
    var userOnChange = customOptions.onChange;
    var altInputClass = customOptions.altInputClass || "";

    delete customOptions.onReady;
    delete customOptions.onOpen;
    delete customOptions.onMonthChange;
    delete customOptions.onYearChange;
    delete customOptions.onChange;
    delete customOptions.altInputClass;

    element.readOnly = true;
    element.setAttribute("inputmode", "none");

    if (altInputClass) {
      element.classList.add.apply(
        element.classList,
        altInputClass.split(/\s+/).filter(Boolean),
      );
    }

    var bounds = normalizeBounds(customOptions);
    var allowedDates = Array.isArray(customOptions.enable)
      ? new Set(customOptions.enable)
      : null;

    delete customOptions.enable;
    delete customOptions.yearBounds;
    delete customOptions.position;

    var defaultDate = parseDate(customOptions.defaultDate);
    delete customOptions.defaultDate;

    var adapter = {
      clear: function () {},
      open: function () {},
      close: function () {},
      destroy: function () {},
      _instance: null,
    };

    var picker = new AirDatepickerCtor(
      element,
      Object.assign(
        {
          locale: getSpanishLocale(),
          showEvent: "click",
          autoClose: true,
          dateFormat: "yyyy-MM-dd",
          selectedDates: defaultDate ? [defaultDate] : [],
          minDate: bounds.minDate || undefined,
          maxDate: bounds.maxDate || undefined,
          onRenderCell: function (ctx) {
            if (!allowedDates || ctx.cellType !== "day") {
              return {};
            }

            var ymd = formatYmd(ctx.date);
            return { disabled: !allowedDates.has(ymd) };
          },
          onShow: function (isFinished) {
            if (isFinished && typeof userOnOpen === "function") {
              var selected = picker.selectedDates || [];
              userOnOpen(
                selected,
                selected[0] ? formatYmd(selected[0]) : "",
                adapter,
              );
            }
          },
          onChangeViewDate: function () {
            var selected = picker.selectedDates || [];
            var dateStr = selected[0] ? formatYmd(selected[0]) : "";

            if (typeof userOnMonthChange === "function") {
              userOnMonthChange(selected, dateStr, adapter);
            }

            if (typeof userOnYearChange === "function") {
              userOnYearChange(selected, dateStr, adapter);
            }
          },
          onSelect: function (ctx) {
            var selectedDates = coerceSelectedDates(ctx.date);
            var dateStr = selectedDates[0] ? formatYmd(selectedDates[0]) : "";

            element.value = dateStr;

            if (typeof userOnChange === "function") {
              userOnChange(selectedDates, dateStr, adapter);
            }
          },
        },
        customOptions,
      ),
    );

    element.addEventListener("click", function () {
      picker.show();
    });

    adapter._instance = picker;
    adapter.clear = function () {
      picker.clear();
      element.value = "";
      if (typeof userOnChange === "function") {
        userOnChange([], "", adapter);
      }
    };
    adapter.open = function () {
      picker.show();
    };
    adapter.close = function () {
      picker.hide();
    };
    adapter.destroy = function () {
      picker.destroy();
    };

    if (defaultDate) {
      element.value = formatYmd(defaultDate);
    }

    if (typeof userOnReady === "function") {
      var selectedReady = picker.selectedDates || [];
      userOnReady(
        selectedReady,
        selectedReady[0] ? formatYmd(selectedReady[0]) : "",
        adapter,
      );
    }

    return adapter;
  };
})();
