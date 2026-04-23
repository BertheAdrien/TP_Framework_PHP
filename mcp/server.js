import axios from "axios";
import { Server } from "@modelcontextprotocol/sdk/server/index.js";
import { StdioServerTransport } from "@modelcontextprotocol/sdk/server/stdio.js";

const LARAVEL_API = "http://localhost:8000/api";

const server = new Server(
  {
    name: "laravel-films-mcp",
    version: "1.0.0",
  },
  {
    capabilities: {
      tools: {},
    },
  }
);

server.setRequestHandler("tools/list", async () => {
  return {
    tools: [
      {
        name: "list_films",
        description: "List all films",
        inputSchema: {
          type: "object",
          properties: {},
        },
      },
      {
        name: "get_locations_for_film",
        description: "Get locations for a film",
        inputSchema: {
          type: "object",
          properties: {
            film_id: { type: "number" },
          },
          required: ["film_id"],
        },
      },
    ],
  };
});

server.setRequestHandler("tools/call", async (request) => {
  const { name, arguments: args } = request.params;

  // TOOL 1
  if (name === "list_films") {
    const res = await axios.get(`${LARAVEL_API}/films`);

    return {
      content: [
        {
          type: "text",
          text: JSON.stringify(res.data, null, 2),
        },
      ],
    };
  }

  // TOOL 2
  if (name === "get_locations_for_film") {
    const res = await axios.get(
      `${LARAVEL_API}/films/${args.film_id}/locations`
    );

    return {
      content: [
        {
          type: "text",
          text: JSON.stringify(res.data, null, 2),
        },
      ],
    };
  }

  throw new Error("Unknown tool: " + name);
});

const transport = new StdioServerTransport();
await server.connect(transport);