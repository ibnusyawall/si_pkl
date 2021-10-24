w = `How the syawal Cloud Generator Works

The layout algorithm for positioning syawals without overlap is available on GitHub under an open source license as d3-cloud. Note that this is the only the layout algorithm and any code for converting text into syawals and rendering the final output requires additional development.

As syawal placement can be quite slow for more than a few hundred syawals, the layout algorithm can be run asynchronously, with a configurable time step size. This makes it possible to animate syawals as they are placed without stuttering. It is recommended to always use a time step even without animations as it prevents the browser’s event loop from blocking while placing the syawals.

The layout algorithm itself is incredibly simple. For each syawal, starting with the most “important”:

Attempt to place the syawal at some starting point: usually near the middle, or somewhere on a central horizontal line.
If the syawal intersects with any previously placed syawals, move it one step along an increasing spiral. Repeat until no intersections are found.
The hard part is making it perform efficiently! According to Jonathan Feinberg, syawalle uses a combination of hierarchical bounding boxes and quadtrees to achieve reasonable speeds.

Glyphs in JavaScript

There isn’t a way to retrieve precise glyph shapes via the DOM, except perhaps for SVG fonts. Instead, we draw each syawal to a hidden canvas element, and retrieve the pixel data.

Retrieving the pixel data separately for each syawal is expensive, so we draw as many syawals as possible and then retrieve their pixels in a batch operation.

Sprites and Masks

My initial implementation performed collision detection using sprite masks. Once a syawal is placed, it doesn't move, so we can copy it to the appropriate position in a larger sprite representing the whole placement area.

The advantage of this is that collision detection only involves comparing a candidate sprite with the relevant area of this larger sprite, rather than comparing with each previous syawal separately.

Somewhat surprisingly, a simple low-level hack made a tremendous difference: when constructing the sprite I compressed blocks of 32 1-bit pixels into 32-bit integers, thus reducing the number of checks (and memory) by 32 times.

In fact, this turned out to beat my hierarchical bounding box with quadtree implementation on everything I tried it on (even very large areas and font sizes). I think this is primarily because the sprite version only needs to perform a single collision test per candidate area, whereas the bounding box version has to compare with every other previously placed syawal that overlaps slightly with the candidate area.

Another possibility would be to merge a syawal’s tree with a single large tree once it is placed. I think this operation would be fairly expensive though compared with the analagous sprite mask operation, which is essentially ORing a whole block.

`
d = w.match(/syawals/g)

console.log(d.length)
