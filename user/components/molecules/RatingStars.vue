<template>
  <div class="star-rating">
    <div
      v-for="(star, index) in stars"
      :key="index"
      class="star-container"
    >
      <svg
        class="star-svg"
        :style="[
          { fill: `url(#gradient${star.raw})` },
          { width: style.starWidth },
          { height: style.starHeight }
        ]"
      >
        <polygon
          :points="getStarPoints"
          style="fill-rule:nonzero;"
        />
        <defs>
          <!--
            id has to be unique to each star fullness(dynamic offset) - it indicates fullness above
          -->
          <linearGradient :id="`gradient${star.raw}`">
            <stop
              id="stop1"
              :offset="star.percent"
              stop-opacity="1"
              :stop-color="getFullFillColor(star)"
            />
            <stop
              id="stop2"
              :offset="star.percent"
              stop-opacity="0"
              :stop-color="getFullFillColor(star)"
            />
            <stop
              id="stop3"
              :offset="star.percent"
              stop-opacity="1"
              :stop-color="style.emptyStarColor"
            />
            <stop
              id="stop4"
              offset="100%"
              stop-opacity="1"
              :stop-color="style.emptyStarColor"
            />
          </linearGradient>
        </defs>
      </svg>
    </div>
    <div
      class="indicator"
    >
      <span class="box-rating__number">({{ ratingNumber }})</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "RatingStars",

  props:{
    config: {
      type: Object,
      require: true,
      default: () => {}
    },

    rating: {
      type: Number,
      require: true,
      default: 0
    },

    ratingNumber: {
      type: Number,
      require: true,
      default: 0
    }
  },

  data() {
    return {
      stars: [],
      emptyStar: 0,
      fullStar: 1,
      totalStars: 5,
      isIndicatorActive: false,
      style: {
        fullStarColor: "#ed8a19",
        emptyStarColor: "#737373",
        starWidth: 20,
        starHeight: 20
      }
    };
  },

  computed: {
    getStarPoints() {
      let centerX = this.style.starWidth / 2;
      let centerY = this.style.starHeight / 2;

      let innerCircleArms = 5; // a 5 arms star

      let innerRadius = this.style.starWidth / innerCircleArms;
      let innerOuterRadiusRatio = 2.5; // Unique value - determines fatness/sharpness of star
      let outerRadius = innerRadius * innerOuterRadiusRatio;

      return this.calcStarPoints(
        centerX,
        centerY,
        innerCircleArms,
        innerRadius,
        outerRadius
      );
    }
  },

  watch: {
    rating(val){
      if(val){
        this.setStars()
      }
    }
  },
  
  mounted() {
    this.initStars()
    this.setStars()
    this.setConfigData()
  },

  methods: {
    /**
     * calc start point
     * 
     * @param Integer centerX
     * @param Integer centerY
     * @param Integer innerCircleArms
     * @param Integer innerRadius
     * @param Integer outerRadius
     */
    calcStarPoints(
      centerX,
      centerY,
      innerCircleArms,
      innerRadius,
      outerRadius
    ) {
      let angle = Math.PI / innerCircleArms;
      let angleOffsetToCenterStar = 60;

      let totalArms = innerCircleArms * 2;
      let points = "";
      for (let i = 0; i < totalArms; i++) {
        let isEvenIndex = i % 2 == 0;
        let r = isEvenIndex ? outerRadius : innerRadius;
        let currX = centerX + Math.cos(i * angle + angleOffsetToCenterStar) * r;
        let currY = centerY + Math.sin(i * angle + angleOffsetToCenterStar) * r;
        points += currX + "," + currY + " ";
      }
      return points;
    },

    /**
     * init start
     */
    initStars() {
      for (let i = 0; i < this.totalStars; i++) {
        this.stars.push({
          raw: this.emptyStar,
          percent: this.emptyStar + "%"
        });
      }
    },

    /**
     * set start
     */
    setStars() {
      let fullStarsCounter = Math.floor(this.rating);
      for (let i = 0; i < this.stars.length; i++) {
        if (fullStarsCounter !== 0) {
          this.stars[i].raw = this.fullStar;
          this.stars[i].percent = this.calcStarFullness(this.stars[i]);
          fullStarsCounter--;
        } else {
          let surplus = Math.round((this.rating % 1) * 10) / 10; // Support just one decimal
          let roundedOneDecimalPoint = Math.round(surplus * 10) / 10;
          this.stars[i].raw = roundedOneDecimalPoint;
          return (this.stars[i].percent = this.calcStarFullness(this.stars[i]));
        }
      }
    },

    /**
     * set config data
     */
    setConfigData() {
      if (this.config) {
        this.setBindedProp(this.style, this.config.style, "fullStarColor");
        this.setBindedProp(this.style, this.config.style, "emptyStarColor");
        this.setBindedProp(this.style, this.config.style, "starWidth");
        this.setBindedProp(this.style, this.config.style, "starHeight");
        if (this.config.isIndicatorActive) {
          this.isIndicatorActive = this.config.isIndicatorActive;
        }
      }
    },

    /**
     * get color start
     */
    getFullFillColor(starData) {
      return starData.raw !== this.emptyStar
        ? this.style.fullStarColor
        : this.style.emptyStarColor;
    },

    /**
     * calc start full ness
     */
    calcStarFullness(starData) {
      let starFullnessPercent = starData.raw * 100 + "%";
      return starFullnessPercent;
    },

    /**
     * set bind prop
     */
    setBindedProp(localProp, propParent, propToBind) {
      if (propParent[propToBind]) {
        localProp[propToBind] = propParent[propToBind];
      }
    }
  }
};
</script>

<style scoped lang="scss">
.star-rating {
  display: flex;
  align-items: center;
  .star-container {
    display: flex;
  }
  .star-container:not(:last-child) {
    margin-right: 5px;
  }
}
</style>
